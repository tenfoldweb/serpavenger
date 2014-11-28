<?php

/**
 *
 *     Author: Alex Scott
 *      Email: alex@cgi-central.net
 *        Web: http://www.cgi-central.net
 *    Details: Affiliate management routines
 *    FileName $RCSfile$
 *    Release: 4.4.2 ($Revision$)
 *
 * Please direct bug reports,suggestions or feedback to the cgi-central forums.
 * http://www.cgi-central.net/forum/
 *
 *
 * aMember PRO is a commercial software. Any distribution is strictly prohibited.
 *
 */
class Am_BannerRenderer
{

    protected $affBanner = null;

    public function __construct(AffBanner $affBanner)
    {
        $this->affBanner = $affBanner;
    }

    public static function create(AffBanner $affBanner)
    {
        switch ($affBanner->type) {
            case AffBanner::TYPE_TEXTLINK :
                return new Am_BannerRenderer_TextLink($affBanner);
                break;
            case AffBanner::TYPE_BANNER :
                return new Am_BannerRenderer_Banner($affBanner);
                break;
            case AffBanner::TYPE_LIGHTBOX :
                return new Am_BannerRenderer_Lightbox($affBanner);
                break;
            case AffBanner::TYPE_PAGEPEEL :
                return new Am_BannerRenderer_Pagepeel($affBanner);
                break;
            case AffBanner::TYPE_CUSTOM :
                return new Am_BannerRenderer_Custom($affBanner);
                break;
            default:
                throw new Am_Exception_InternalError(
                    'Can not instantiate banner with type : ' . $affBanner->type
                );
        }
    }

    /**
     * Should be overriden in subclasses
     */
    public function getCode()
    {
        throw new Am_Exception_NotImplemented();
    }

    /**
     * Should be overriden in subclasses
     */
    public function getPreview()
    {
        return $this->getCode();
    }

    public function getNote()
    {
        return false;
    }

    public function getUrl()
    {
        return sprintf('%s/aff/go/%s/?i=%d', ROOT_URL, urlencode(Am_Di::getInstance()->auth->getUser()->login), $this->affBanner->pk());
    }

}

class Am_BannerRenderer_TextLink extends Am_BannerRenderer
{

    public function getCode()
    {
        return sprintf('<a href="%s">%s</a>',
            $this->getUrl(),
            $this->affBanner->title
        );
    }

}

class Am_BannerRenderer_Custom extends Am_BannerRenderer
{

    public function getCode()
    {
        return str_replace('%url%', $this->getUrl(), $this->affBanner->html);
    }

}

class Am_BannerRenderer_Banner extends Am_BannerRenderer
{

    public function getCode()
    {
        $upload = Am_Di::getInstance()->uploadTable->load($this->affBanner->upload_id);

        return sprintf('<a href="%s"><img src="%s" border=0 alt="%s" %s %s></a>',
            $this->getUrl(),
            ROOT_URL . '/file/get/path/' . $upload->getPath() . '/i/' . Am_Di::getInstance()->auth->getUserId(),
            Am_Controller::escape($this->affBanner->title),
            ($this->affBanner->width ? sprintf('width="%s"', $this->affBanner->width) : ''),
            ($this->affBanner->height ? sprintf('height="%s"', $this->affBanner->height) : '')
        );
    }

}

class Am_BannerRenderer_Lightbox extends Am_BannerRenderer
{

    public function getCode()
    {
        $upload = Am_Di::getInstance()->uploadTable->load($this->affBanner->upload_id);
        $upload_big = Am_Di::getInstance()->uploadTable->load($this->affBanner->upload_big_id);
        return sprintf('<a href="%s" rel="lightbox" rev="%s" title="%s"><img src="%s" border=0 alt="%s"></a>',
            ROOT_URL . '/file/get/path/' . $upload_big->getPath() . '/i/' . Am_Di::getInstance()->auth->getUserId(),
            $this->getUrl(),
            $this->affBanner->title,
            ROOT_URL . '/file/get/path/' . $upload->getPath() . '/i/' . Am_Di::getInstance()->auth->getUserId(),
            Am_Controller::escape($this->affBanner->title)
        );
    }

    public function getNote()
    {
        return sprintf(___('Paste the following code into the section &lt;head&gt; of your html document.') . '<br />
            <textarea rows="6" class="el-wide" style="overflow:scroll"><link rel="stylesheet" type="text/css" href="%s/application/aff/views/public/css/jquery.lightbox.css" media="screen" />
<script type="text/javascript" src="%s/application/aff/views/public/js/jquery.lightbox.js"></script>
<script type="text/javascript">
var am_url = "%s";
var am_lightbox = {
    imageLoading : am_url + "lightbox-ico-loading.gif",
    imageBtnClose : am_url + "lightbox-btn-close.gif",
    imageBlank : am_url + "lightbox-blank.gif"
};
</script></textarea><br />You only need to place this code one time.',
            ROOT_URL, ROOT_URL, ROOT_URL,
            ROOT_URL . '/application/aff/views/public/img/'
        );
    }

}

class Am_BannerRenderer_Pagepeel extends Am_BannerRenderer
{

    public function getCode()
    {
        throw new Am_Exception_NotImplemented();
    }

}

class Aff_AffController extends Am_Controller
{

    function init()
    {
        if (!class_exists('Am_Form_Brick', false)) {
            class_exists('Am_Form_Brick', true);
            Am_Di::getInstance()->hook->call(Am_Event::LOAD_BRICKS);
        }
        parent::init();
    }

    public function preDispatch()
    {
        $this->getDi()->auth->requireLogin(ROOT_URL . '/aff/aff');
        if ($this->getRequest()->getActionName() != 'enable-aff')
            if (!$this->getDi()->user->is_affiliate)
                $this->_redirect('member');
    }

    public function indexAction()
    {
        return $this->linksAction();
    }

    public function linksAction()
    {
        $this->getView()->headLink()->appendStylesheet(
            REL_ROOT_URL . '/application/aff/views/public/css/jquery.lightbox.css'
        );
        $this->getView()->headScript()->appendFile(
            REL_ROOT_URL . '/application/aff/views/public/js/jquery.lightbox.js'
        )->appendScript(
            sprintf('var am_url = "%s";
var am_lightbox = {
imageLoading : am_url + "lightbox-ico-loading.gif",
imageBtnPrev : am_url + "lightbox-btn-prev.gif",
imageBtnNext : am_url + "lightbox-btn-next.gif",
imageBtnClose : am_url + "lightbox-btn-close.gif",
imageBlank : am_url + "lightbox-blank.gif"
};', ROOT_URL . '/application/aff/views/public/img/')
        );


        $catActive = $this->getParam('c', null);
        $affBanners = $this->getDi()->affBannerTable->findActive($catActive);

        $user_group_ids = $this->getDi()->user->getGroups();
        foreach ($affBanners as $k => $v) {
            if ($v->user_group_id && !array_intersect($user_group_ids, explode(',', $v->user_group_id)))
                unset($affBanners[$k]);
        }

        $affDownloads = $catActive ? null : $this->getDi()->uploadTable->findByPrefix('affiliate');

        if ($catActive) {
            $this->view->getHelper('breadcrumbs')->setPath(array(
                REL_ROOT_URL . '/aff/aff' => ___('Affiliate info'),
                $catActive));
        }

        $this->view->assign('intro', $this->getModule()->getConfig('intro'));
        $this->view->assign('canUseCustomRedirect', $this->canUseCustomRedirect($this->getDi()->user));
        $this->view->assign('catActive', $catActive);
        $this->view->assign('category', $this->getDi()->affBannerTable->getCategories(true));
        $this->view->assign('generalLink', sprintf('%s/aff/go/%s', ROOT_URL, urlencode(Am_Di::getInstance()->auth->getUser()->login)));
        $this->view->assign('affDownloads', $affDownloads);
        $this->view->assign('affBanners', $affBanners);
        $this->view->display('aff/links.phtml');
    }

    public function enableAffAction()
    {
        if ($this->getDi()->config->get('aff.signup_type') == 2) {
            throw new Am_Exception_AccessDenied('Signup disabled in config');
        }

        $user = $this->getDi()->user;
        if (!$user->is_affiliate) {
            if (!$this->checkAffAgreementIfRequired($user))
                return;
            $user->is_affiliate = 1;
            $user->update();
        }

        return $this->linksAction();
    }

    public function checkAffAgreementIfRequired(User $user)
    {
        $signupForm = $this->getDi()->savedFormTable->getByType('aff');
        if (!$signupForm)
            return true;

        foreach ($signupForm->getBricks() as $brick)
            if ($brick instanceof Am_Form_Brick_Agreement) {
                $form = new Am_Form('aff');
                $brick->insertBrick($form);
                $form->addSubmit('agree', array('value' => ___('Continue')));

                if ($form->validate())
                    return true;

                $view = $this->view;
                $view->title = $this->getDi()->config->get('site_title');
                $view->content = (string) $form;
                $view->display('layout.phtml');
                return false;
            }

        return true;
    }

    public function statsAction()
    {
        $this->_forward('stats', 'member');
    }

    //lowercase becuase of ?action=payout_info does not work with payoutInfoAction
    public function payoutinfoAction()
    {
        $this->_forward('payout-info', 'member');
    }

    public function clinkAction()
    {
        if (!($user = $this->getDi()->auth->getUser()))
            $link = ROOT_URL;
        elseif (!$user->is_affiliate)
            $link = ROOT_URL;
        else {
            $cr = $this->getDi()->config->get('aff.custom_redirect');
            if (($cr == Bootstrap_Aff::AFF_CUSTOM_REDIRECT_ALLOW_SOME_DENY_OTHERS && $user->aff_custom_redirect) ||
                ($cr == Bootstrap_Aff::AFF_CUSTOM_REDIRECT_DENY_SOME_ALLOW_OTHERS && !$user->aff_custom_redirect)) {
                $url = $this->getParam('url', '');
                if (!preg_match('!^https?://!i', $url))
                    $link = sprintf('%s/aff/go/%s', ROOT_URL, urlencode($user->login));
                else
                {
                    if($this->getDi()->config->get('aff.tracking_code') && $this->pageHaveTrackingCode($url))
                    $link = $this->getRefLink($user->login, $url);
                    else    
                    $link = sprintf('%s/aff/go/%s/?cr=%s', ROOT_URL, urlencode($user->login), base64_encode($url));
                    
                }
            }
            else
                $link = sprintf('%s/aff/go/%s', ROOT_URL, urlencode($user->login));
        }
        $ret = array(
            'link' => $link,
        );
        $this->ajaxResponse($ret);
    }

    protected function canUseCustomRedirect(User $user)
    {
        $cr = $this->getModule()->getConfig('custom_redirect');
        return ($cr == Bootstrap_Aff::AFF_CUSTOM_REDIRECT_ALLOW_SOME_DENY_OTHERS && $user->aff_custom_redirect) ||
            ($cr == Bootstrap_Aff::AFF_CUSTOM_REDIRECT_DENY_SOME_ALLOW_OTHERS && !$user->aff_custom_redirect);
    }
    
    /**
     * Check whereever given url have tracking code included
     * @param type $url
     */
    function pageHaveTrackingCode($url){
        $req = new Am_HttpRequest($url, Am_HttpRequest::METHOD_GET);
        try{
            $resp = $req->send();
        }catch(Exception $e){
            $this->getDi()->errorLogTable->logException($e);
            return false;
        }
        if(strpos($resp->getBody(), "id='am-ctcs-v1'")!== false)
            return true;
            
        return false;
    }
    
    
    function getRefLink($login, $url){
        $url = parse_url($url);
        parse_str(@$url['query'], $query);
        $query['ref'] = $login;
        $url['query'] = http_build_query($query);
        return sprintf("%s://%s%s%s", $url['scheme'], $url['host'], $url['path']?$url['path']:'/', $url['query']? "?".$url['query'] : '');
    }

}