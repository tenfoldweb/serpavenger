<?php
/*
*
*
*     Author: Alex Scott
*      Email: alex@cgi-central.net
*        Web: http://www.cgi-central.net
*    Details: upgrade DB from ../amember.sql
*    FileName $RCSfile$
*    Release: 4.4.2 ($Revision$)
*
* Please direct bug reports,suggestions or feedback to the cgi-central forums.
* http://www.cgi-central.net/forum/
*
* aMember PRO is a commercial software. Any distribution is strictly prohibited.
*
*/

class AdminUpgradeDbController extends Am_Controller
{
    protected $db_version;
    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->isSuper();
    }
    function convert_to_new_keys()
    {
        return;
        if (!$this->getDi()->modules->isEnabled('cc'))
            return;
        if (!file_exists(APPLICATION_PATH . '/configs/key.php')) return;
        $key = require_once APPLICATION_PATH . '/configs/key.php';
        
        $cryptNew = $this->getDi()->crypt;
        if ($cryptNew->compareKeySignatures() == 0) return;
        if (!file_exists(APPLICATION_PATH . '/configs/key-old.inc.php')) {
            print "
    <div style='color: red'><br />To convert your encrypted values to use new keystring,
    please copy old file <i>amember/application/confgigs/key.php</i> to
    <i>amember/application/confgigs/key-old.inc.php</i> and run this 'Upgrade Db' utility again.
    <br /><br />
    <b>It is also required to make backup of your database before conversion. GGI-Central is not responsible for any damage
    the conversion may result to if you have no backup saved before conversion. Please make backup first, then go back here for conversion.</b>
    <br />
    <br /> Once you made backup of the database and key file, please click <a href='admin-upgrade-db?refresh=".time()."'>this link</a> to run upgrade script again.
    </div>
            " ;
            return false;
        }
        $cryptOld = new Am_Crypt_Strong(require APPLICATION_PATH . '/configs/key-old.inc.php');
        $q = $this->getDi()->db->queryResultOnly("SELECT * FROM ?_cc");
        // dry run
        print "<br />Checking CC Records with old key..."; ob_flush();
        $count = 0;
        while ($r = mysql_fetch_assoc($q)){
            $cc = $this->getDi()->ccRecordRecord;
            $cc->setCrypt($cryptOld);
            $cc->fromRow($r);
            if (preg_match('/[^\s\d-]/', $cc->cc_number)) {
                print "<div style='color: red'>Problem with converting to new encryption key:</br>
                    cc record# {$cc->cc_id} could not be converted, it seems the old key has been specified incorrectly. Conversion cancelled.</div>";
                return;
            }
            $count++;
        }
        print "OK ($counts)\n<br />";
        print "Converting CC records with new key..."; ob_flush();
        // real run
        $q = $this->getDi()->db->queryResultOnly("SELECT * FROM ?_cc");
        $count = 0;
        while ($r = mysql_fetch_assoc($q)){
            $cc = $this->getDi()->ccRecordRecord;
            $cc->setCrypt($cryptOld);
            $cc->fromRow($r);
            if (preg_match('/[^\s\d-]/', $cc->cc_number)) {
                print "<div style='color: red'>Problem with converting to new encryption key:</br>
                    cc record# {$cc->cc_id} could not be converted, it seems the old key has been specified incorrectly. Conversion cancelled.</div>";
                return;
            }
            $cc->setCrypt($cryptNew);
            $cc->update();
            $count++;
        }
        $cryptNew->saveKeySigunature();

        print "OK ($count)\n<br />"; ob_flush();
        $this->getDi()->db->query("OPTIMIZE TABLE ?_cc"); // to remove stalled records
    }
    function indexAction()
    {
        $this->getDi()->db->setLogger(false);

        $t = new Am_View;
        set_time_limit(0);
        ini_set('memory_limit', '256M');

        $this->db_version = $this->getDi()->store->get('db_version');
        
        if (defined('AM_DEBUG')) ob_start();
        ?><!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>aMember Database Upgrade</title>
            <style type="text/css">
            <!--
            body {
                font-family: Arial;
                background:#EDEDED;
                text-align: center;
            }

            a, a:visited {
                color: #34536e;
            }
            .am-upgrade-body {
                display:inline-block;
                text-align: left;
                max-width:800px;
            }
            -->
            </style>
        </head>
        <body>
        <div class="am-upgrade-body">
        <h1>aMember Database Upgrade</h1>
        <hr />
        <?php


        /* ******************************************************************************* *
         *                  M A I N
         */
        $this->fixNotUniqueRecordInRebillLog();
        $this->fixNotUniquePathInPages();
        $this->getDi()->app->dbSync(true);
        $this->convert_to_new_keys();
        $this->checkInvoiceItemTotals();
        $this->convertTax();
        $this->convertAutoresponderPrefix();
        $this->enableSkipIndexPage();
        $this->manuallyApproveInvoices();
        $this->addCountryCodes();
        $this->fillResourceAccessSort();
        $this->upgradeFlowPlayerKey();
        $this->fixCryptSavedPass();
        $this->updateStateInfo();
        $this->fixCustomFieldSortTableName();
        $this->normalizeProductSortOrder();
        $this->fixPagePath();
        $this->setupDefaultProtcetionForCustomFields();
        $this->populateInvoicePublicId();
        $this->populateCouponCode();
        $this->convert0toNull();
        $this->fixLogoutRedirectSettings();
        $this->fixUserStatusTable();
        $this->populateAffAddedField();
        $this->convertFreeWithoutAccessFoldersToLinks();
        $this->getDi()->hook->call(new Am_Event(Am_Event::DB_UPGRADE, array('version' => $this->db_version)));

        $version = AM_VERSION;
        $year = date('Y');
        $copyright = <<<CUT
<div style="text-align:center; font-size:70%">
        aMember Pro&trade; $version by <a href="http://www.amember.com">aMember.com</a>  &copy; 2002&ndash;$year CGI-Central.Net
</div>
CUT;
        echo "
        <br/><strong>Upgrade finished successfully.
        Go to </strong><a href='".REL_ROOT_URL."/admin/'>aMember Admin CP</a>.
        <hr />
        $copyright
        </div>
        </body></html>";
    }

    function fixNotUniqueRecordInRebillLog()
    {
        //to set unique index (invoice_id,rebill_date)
        if (version_compare($this->db_version, '4.2.15') < 0)
        {
            $db = $this->getDi()->db;
            try { //to handle situation when ?_cc_rebill table does not exists
                $db->query('CREATE TEMPORARY TABLE ?_cc_rebill_temp (
                    cc_rebill_id int not null,
                    tm_added datetime not null,
                    paysys_id varchar(64),
                    invoice_id int,
                    rebill_date date,
                    status smallint,
                    status_tm datetime,
                    status_msg varchar(255),
                    UNIQUE INDEX(invoice_id, rebill_date))');

                $db->query('
                    INSERT IGNORE INTO ?_cc_rebill_temp
                    SELECT * FROM ?_cc_rebill
                ');
                
                $db->query("TRUNCATE ?_cc_rebill");
                
                $db->query('
                    INSERT INTO ?_cc_rebill
                    SELECT * FROM ?_cc_rebill_temp
                ');
                
                $db->query("DROP TABLE ?_cc_rebill_temp");
            } catch (Exception $e) {
                
            }
        }
    }

    function fillResourceAccessSort()
    {
        $this->getDi()->resourceAccessTable->syncSortOrder();
    }
    
    function manuallyApproveInvoices(){
        if((version_compare($this->db_version, '4.2.4') <0) || 
            ((version_compare(AM_VERSION, '4.2.7')<=0) && !$this->getDi()->config->get('manually_approve_invoice'))
            )
        {
            echo "Manually approve old invoices...";     
            @ob_end_flush();
            
            $this->getDi()->db->query("update ?_invoice set is_confirmed=1");
            echo "Done<br/>\n";
        }
    }
    
    function checkInvoiceItemTotals()
    {
        if (version_compare($this->db_version, '4.1.8') < 0)
        {
            echo "Update invoice_item.total columns...";     
            @ob_end_flush();
            $this->getDi()->db->query("
                UPDATE ?_invoice_item
                SET 
                    first_total = first_price*qty - first_discount + first_shipping + first_tax,
                    second_total = second_price*qty - second_discount + second_shipping + second_tax
                WHERE 
                    ((first_total IS NULL OR first_total = 0) AND first_price > 0)
                OR 
                    ((second_total IS NULL OR second_total = 0) AND second_price > 0)
                ");
            echo "Done<br>\n";
        }
    }
    function convertTax()
    {
        if (version_compare($this->db_version, '4.2.0') < 0)
        {
            echo "Move product.no_tax -> product.tax columns...";     
            @ob_end_flush();
            try {
                $this->getDi()->db->query("
                UPDATE ?_product
                SET tax_group = IF(IFNULL(no_tax, 0) = 0, 0, 1)
                ");
//                $this->getDi()->db->query("ALTER TABLE ?_product DROP no_tax");
            } catch (Am_Exception_Db $e) { } 
            
            echo "Move invoice_item.no_tax -> invoice_item.tax_group columns...";     
            @ob_end_flush();
            try {
               $this->getDi()->db->query("
                UPDATE ?_invoice_item
                SET tax_group = IF(IFNULL(no_tax, 0) = 0, 0, 1)
                ");
//                $this->getDi()->db->query("ALTER TABLE ?_invoice_item DROP no_tax");
            } catch (Am_Exception_Db $e) { } 
            echo "Done<br>\n";
            
            echo "Migrate tax settings..."; 
            if ($this->getDi()->config->get('use_tax'))
            {
                $config = $this->getDi()->config;
                $config->read();
                switch ($this->getDi()->config->get('tax_type'))
                {
                    case 1:
                        $config->set('plugins.tax', array('global-tax'));
                        $config->set('tax.global-tax.rate', $config->get('tax_value'));
                        break;
                    case 2:
                        $config->set('plugins.tax', array('regional')); 
                        $config->set('tax.regional.taxes', $config->get('regional_taxes'));
                        break;
                }
                $arr = $config->getArray();
                unset($arr['tax_type']);
                unset($arr['regional_taxes']);
                unset($arr['tax_value']);
                unset($arr['use_tax']);
                $config->setArray($arr);
                $config->save();
            }
            echo "Done<br>\n";
        }
    }

    function convertAutoresponderPrefix()
    {
        if (version_compare($this->db_version, '4.2.0') < 0)
        {
            echo "Convert Autoresponder Prefix From [emailtemplate] to [email-messages]";
            @ob_end_flush();
            try {
                $rows = $this->getDi()->db->query("
                SELECT * FROM ?_email_template
                WHERE name IN ('autoresponder', 'expire') AND attachments IS NOT NULL
                ");

                $upload_ids = array();
                foreach ($rows as $row) {
                    $upload_ids = array_merge($upload_ids, explode(',', $row['attachments']));
                }
                
                if (count($upload_ids)) {
                    $templates = array();
                    foreach ($upload_ids as $id) {
                        $rows = $this->getDi()->db->query("
                            SELECT * FROM ?_email_template
                            WHERE name NOT IN ('autoresponder', 'expire')
                            AND (attachments=? OR attachments LIKE ?
                            OR attachments LIKE ? OR attachments LIKE ?)",
                            $id,
                            '%,'.$id,
                            $id.',%',
                            '%,'.$id.',%'
                            );
                        $templates = array_merge($templates, $rows);
                    }



                    if (count($templates)) {
                        $names = array();
                        foreach ($templates as $tpl) {
                            $names[] = sprintf('%s [%s]', $tpl['name'], $tpl['lang']);
                        }

                        echo sprintf(' <span style="color:red">Please reupload attachments for the following templates: %s</span><br />',
                            implode(', ', $names));
                    }

                    $this->getDi()->db->query("UPDATE ?_upload SET prefix=? WHERE upload_id IN (?a)",
                        'email-messages', $upload_ids);
                }

            } catch (Am_Exception_Db $e) { }
            echo "Done<br>\n";
        }
    }
    function checkResourceAccessEmailTemplates(){
        if (version_compare($this->db_version, '4.1.14') < 0)
        {
            echo "Update resource access table ...";     
            @ob_end_flush();
            $this->getDi()->db->query("
                    UPDATE ?_resource_access
                    SET 
                    start_days = (SELECT day FROM ?_email_template WHERE email_template_id=resource_id),
                    stop_days = (SELECT day FROM ?_email_template WHERE email_template_id=resource_id)
                    WHERE resource_type = 'emailtemplate' AND fn='free' and start_days IS NULL
                    ");
            echo "Done<br>\n";
            
        }   
    }

    function enableSkipIndexPage() {
        if (version_compare($this->db_version, '4.1.16') < 0)
        {
            echo "Enable skip_index_page option...";
            if (ob_get_level()) ob_end_flush();
            $str = $this->getDi()->db->selectCell("SELECT config FROM ?_config WHERE name = ?", 'default');
            $config = unserialize($str);
            if (!isset($config['skip_index_page'])) {
                $config['skip_index_page'] = 1;
                $this->getDi()->db->selectCol("UPDATE ?_config SET config=? WHERE name = ?", serialize($config), 'default');
            }

            echo "Done<br>\n";

        }
    }

    function addCountryCodes() {
        if (version_compare($this->db_version, '4.2.10') < 0)
        {
            echo "Add country codes...";
            if (ob_get_level()) ob_end_flush();
            $query = file_get_contents(ROOT_DIR . '/setup/sql-country.sql');
            $query = str_replace('@DB_MYSQL_PREFIX@', '?_', $query);
            $this->getDi()->db->query($query);
            echo "Done<br>\n";
        }
    }

    function upgradeFlowPlayerKey() {
        if (version_compare($this->db_version, '4.2.16') < 0)
        {
            echo "Update Flowplayer License Key...";
            if (ob_get_level()) ob_end_flush();
            $request = new Am_HttpRequest('https://www.amember.com/fplicense.php', Am_HttpRequest::METHOD_POST);
            $request->addPostParameter('root_url', $this->getDi()->config->get('root_url'));
            try {
                $response = $request->send();
            } catch (Exception $e) {
                echo "request failed " . $e->getMessage() . "\n<br />";
                return;
            }
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                $res = Am_Controller::decodeJson($body);
                if ($res['status'] == 'OK' && $res['license'])
                {
                    Am_Config::saveValue('flowplayer_license', $res['license']);
                }
            }
            echo "Done<br>\n";
        }
    }

    function fixCryptSavedPass()
    {
        if (version_compare($this->db_version, '4.2.16') < 0)
        {
            echo "Fix crypt saved pass...";
            if (ob_get_level()) ob_end_flush();
            $this->getDi()->db->query("UPDATE ?_saved_pass SET salt=pass WHERE format=?", 'crypt');
            echo "Done<br>\n";
        }
    }

    function updateStateInfo() {
        if (version_compare($this->db_version, '4.2.16') < 0)
        {
            echo "Update State Info...";
            if (ob_get_level()) ob_end_flush();
            $query = file_get_contents(ROOT_DIR . '/setup/sql-state.sql');
            $query = str_replace('@DB_MYSQL_PREFIX@', '?_', $query);
            $this->getDi()->db->query($query);
            echo "Done<br>\n";
        }
    }

    function fixCustomFieldSortTableName() {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            echo "Rename custom_fields_sort to custom_field_sort...";
            if (ob_get_level()) ob_end_flush();
            try {
                //actually we move data from old table to new one here to leave user preference
                if (!$this->getDi()->db->selectCell("SELECT COUNT(*) FROM ?_custom_field_sort")) {
                    $this->getDi()->db->query("SET @i = 0");
                    $this->getDi()->db->query("INSERT INTO ?_custom_field_sort (custom_field_table, custom_field_name, sort_order)
                        SELECT custom_field_table, custom_field_name, (@i:=@i+1) FROM ?_custom_fields_sort ORDER BY sort_order");
                }
            } catch (Exception $e) {
                //nop, handle situsation for upgrade from version where ?_custom_fields_sort is not exists yet
            }
            echo "Done<br>\n";
        }
    }

    function normalizeProductSortOrder() {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            echo "Normalize sort order for products...";
            if (ob_get_level()) ob_end_flush();
            $this->getDi()->db->query("SET @i = 0");
            $this->getDi()->db->query("UPDATE ?_product SET sort_order=(@i:=@i+1) ORDER BY sort_order");
            echo "Done<br>\n";
        }
    }

    function fixNotUniquePathInPages()
    {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            echo "Fix Not Unique Path in Pages...";
            if (ob_get_level()) ob_end_flush();
            $this->getDi()->db->query("UPDATE ?_page SET path = page_id WHERE path=''");
            echo "Done<br>\n";
        }
    }

    function fixPagePath() {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            echo "Fix Page Path...";
            if (ob_get_level()) ob_end_flush();
            $this->getDi()->db->query("UPDATE ?_page SET path = NULL WHERE path=page_id");
            echo "Done<br>\n";
        }
    }

    function setupDefaultProtcetionForCustomFields() {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            echo "Setup default protection for custom fields...";
            foreach($this->getDi()->userTable->customFields()->getAll() as $field) {
                if (isset($field->from_config) && $field->from_config)
                    $this->getDi()->resourceAccessTable->setAccess(amstrtoint($field->name), Am_CustomField::ACCESS_TYPE, array(
                        ResourceAccess::FN_FREE_WITHOUT_LOGIN => array(
                            json_encode(array(
                                'start' => null,
                                'stop' => null,
                                'text' => ___('Free Access without log-in')
                        )))
                    ));
            }
            echo "Done<br>\n";
        }
    }

    function populateInvoicePublicId()
    {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            echo "Populate Invoice Public Id (Denormalization)...";
            foreach (array('?_access',
                '?_invoice_item',
                '?_invoice_payment',
                '?_invoice_refund') as $table) {

                $this->getDi()->db->query("UPDATE $table t SET invoice_public_id =
                    (SELECT public_id FROM ?_invoice i WHERE i.invoice_id=t.invoice_id)
                    WHERE t.invoice_id IS NOT NULL");
            }
            echo "Done<br>\n";
        }
    }

    function populateCouponCode()
    {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            echo "Populate Coupon Code (Denormalization)...";
            $this->getDi()->db->query("UPDATE ?_invoice t SET coupon_code =
                    (SELECT code FROM ?_coupon c WHERE c.coupon_id=t.coupon_id)
                    WHERE t.coupon_id IS NOT NULL");
            echo "Done<br>\n";
        }
    }

    function convert0toNull()
    {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            echo "Convert 0 to NULL...";
            $this->getDi()->db->query("UPDATE ?_access SET invoice_id=NULL
                    WHERE invoice_id=0");
            $this->getDi()->db->query("UPDATE ?_access SET invoice_payment_id=NULL
                    WHERE invoice_payment_id=0");
            $this->getDi()->db->query("UPDATE ?_access SET invoice_item_id=NULL
                    WHERE invoice_item_id=0");
            $this->getDi()->db->query("UPDATE ?_access SET transaction_id=NULL
                    WHERE transaction_id=''");
            echo "Done<br>\n";
        }
    }

    function fixLogoutRedirectSettings()
    {
        if (version_compare($this->db_version, '4.2.20') < 0)
        {
            if (!$this->getDi()->config->get('protect.php_include.redirect_logout') &&
                $this->getDi()->config->get('protect.php_include.redirect')) {
                Am_Config::saveValue('protect.php_include.redirect_logout', 'url');

                $this->getDi()->config->read();
            }
        }
    }

    function fixUserStatusTable()
    {
        if (version_compare($this->db_version, '4.3.3') < 0)
        {
            echo "Fix ?_user_status table...";
            $this->getDi()->db->query("DELETE FROM ?_user_status WHERE user_id NOT IN (SELECT user_id FROM ?_user)");
            echo "Done<br>\n";
        }
    }

    function populateAffAddedField()
    {
        if (version_compare($this->db_version, '4.3.3') < 0)
        {
            echo "Populate aff_added field...";
            $this->getDi()->db->query("UPDATE ?_user SET aff_added=added WHERE aff_id>0 AND aff_added IS NULL");
            echo "Done<br>\n";
        }
    }

    function convertFreeWithoutAccessFoldersToLinks()
    {
        if (version_compare($this->db_version, '4.3.4') < 0)
        {
            echo "Converst Free Without Access Folders to Links...";
            foreach($this->getDi()->resourceAccessTable->findBy(array(
                'fn' => ResourceAccess::FN_FREE_WITHOUT_LOGIN,
                'resource_type' => ResourceAccess::FOLDER
                )) as $rec) {

                try {
                    $folder = $this->getDi()->folderTable->load($rec->resource_id);
                    $link = $this->getDi()->linkRecord;
                    foreach (array('title', 'desc', 'url', 'hide') as $prop) {
                        $link->{$prop} = $folder->{$prop};
                    }
                    $link->save();
                    $link->setAccess(array(
                        ResourceAccess::FN_FREE => array(
                            0 => array(
                                'start' => null,
                                'stop' => null
                            )
                        )
                    ));

                    $sort = $folder->getSortOrder();
                    $folder->delete();
                    $this->unprotectFolder($folder);
                    $link->setSortOrder($sort);
                } catch (Exception $e) {}
            }
            echo "Done<br>\n";
        }
    }

    public function unprotectFolder(Folder $folder)
    {
        $htaccess_path = $folder->path . '/.htaccess';
        if (!is_dir($folder->path)) {
            $this->error('Could not open folder [%s] to remove .htaccess from it. Do it manually', $folder->path);
            return;
        }
        $content = file_get_contents($htaccess_path);
        if (strlen($content) && !preg_match('/^\s*\#+\sAMEMBER START.+AMEMBER FINISH\s#+\s*/s', $content)) {
            $this->error('File [%s] contains not only aMember code - remove it manually to unprotect folder', $htaccess_path);
            return;
        }
        if (!unlink($folder->path . '/.htaccess'))
            $this->error('File [%s] cannot be deleted - remove it manually to unprotect folder', $htaccess_path);
    }

    function error($msg)
    {
        echo sprintf('<span style="color:red">%s</span><br />', $msg);
    }
}
