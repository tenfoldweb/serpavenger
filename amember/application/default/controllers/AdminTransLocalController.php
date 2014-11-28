<?php
/*
*
*
*     Author: Alex Scott
*      Email: alex@cgi-central.net
*        Web: http://www.cgi-central.net
*    Details: Admin accounts
*    FileName $RCSfile$
*    Release: 4.4.2 ($Revision: 4649 $)
*
* Please direct bug reports,suggestions or feedback to the cgi-central forums.
* http://www.cgi-central.net/forum/
*
* aMember PRO is a commercial software. Any distribution is strictly prohibited.
*
*/

require_once('AdminTransGlobalController.php');

class Am_Grid_DataSource_Array_Trans_Local extends Am_Grid_DataSource_Array_Trans
{
    protected function createTDataSource() {
        return new TranslationDataSource_DB();
    }
}

class AdminTransLocalController extends AdminTransGlobalController 
{
    public function createGrid() {
        return $this->_createGrid(___('Local Translations'));
    }

    protected function createDS($language) {
        return new Am_Grid_DataSource_Array_Trans_Local($language);
    }

    public function getTransAction() {
        echo $this->getJson(
        $this->getTrans($this->getRequest()->getParam('text'))
        );
    }

    protected function getTransStat($text) {
        $res = $this->getTrans($text);
        $total = count($this->getDi()->config->get('lang.enabled'))-1;
        $stat = array (
                'total' => ($total < 0 ? 0 : $total),
                'translated' => 0
        );

        $default = $this->getDi()->config->get('lang.default', 'en');

        foreach ($res as $lang => $trans) {
            if (trim($trans) && $lang!=$default) {
                $stat['translated']++;
            }
        }
        
        return $stat;
    }

    public function updateTransAction() {
        foreach ($this->getRequest()->getParam('trans') as $lang => $trans) {
            $toReplace = array();
            $toReplace[$this->getRequest()->getParam('text')] = $trans;
            $this->getDi()->translationTable->replaceTranslation($toReplace, $lang);
        }
        Zend_Translate::hasCache() && Zend_Translate::clearCache();
    }

    
    public function synchronizeAction() {
        $text = $this->getRequest()->getParam('text');
        $res = array(
            'form' => $this->getTransForm($text),
            'stat' => $this->getTransStat($text)
        );
        
        $this->ajaxResponse(
            $res
        );
    }

    public function synchronizeBatchAction() {
        $text = $this->getRequest()->getParam('text');
        $res = array();
        foreach ($text as $t) {
            $res[$t] = array(
                'form' => $this->getTransForm($t),
                'stat' => $this->getTransStat($t)
            );
        }
        
        $this->ajaxResponse(
            $res
        );
    }
    
    protected function getTransForm($text) {
        $trans = $this->getTrans($text);

        $lgList = $this->getDi()->languagesListUser;

        $form = new Am_Form_Admin();

        $form->setAction($this->getUrl(null, 'update-trans'));

        $default = $this->getDi()->config->get('lang.default', 'en');

        $form->addStatic('text_default')->setContent(
                sprintf("<div>%s</div>", $this->escape($text))
        );

        foreach ($trans as $lg=>$t) {
            if ($lg!=$default) {
                $form->addElement('textarea', 'trans[' . $lg . ']', array('class' => 'el-wide'))
                        ->setLabel($lgList[$lg])
                        ->setValue($t);
            }
        }

        $form->addElement('hidden', 'text')
                ->setValue($text);

        return (string)$form;
    }

    protected function getTrans($text) 
    {
        $result = array();

        $langs = $this->getDi()->config->get('lang.enabled', array());

        $tDataSource = new TranslationDataSource_DB();

        foreach ($langs as $lg) {
            $td = $tDataSource->getTranslationData($lg);
            $result[$lg] = (isset($td[$text])) ? $td[$text] : '';
        }
        return $result;
    }
}