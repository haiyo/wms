<?php
namespace Aurora\Page;
use \Aurora\Admin\AdminView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageTabView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageTabView extends AdminView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $L10n;
    protected $View;
    protected $PageModel;
    protected $args;


    /**
    * PageTabView Constructor
    * @return void
    */
    function __construct( PageModel $PageModel, $args ) {
        parent::__construct( );
        /*$this->Registry  = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $this->View      = AuroraView::getInstance( );*/
        $this->PageModel = $PageModel;
        $this->args = $args;

        //$i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $this->i18n->loadLanguage('Aurora/PagesRes');
	}


    /**
    * Page Page Tab
    * @return string
    */
    public function renderTab( ) {
        $pages  = $this->PageModel->getAllPage( );
        $sizeof = sizeof( $pages );

        if( $sizeof > 0 ) {
            $urlKey  = pathinfo( $_SERVER['REQUEST_URI'] );
            $urlKey  = str_replace( '/', '', $urlKey['basename'] );
            $pages   = array_reverse( $pages );
            $gotPage = false;

            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
            $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
            
            $vars['dynamic']['newPage'] = false;

            for( $i=0; $i<$sizeof; $i++ ) {
                if( $pages[$i]['perm'] == 2 ) {
                    if( $pages[$i]['userID'] != $userInfo['userID'] ) {
                        continue;
                    }
                }
                if( $pages[$i]['perm'] == 3 ) {
                    if( !$Authorization->isAdmin( ) && !$Authorization->hasAnyRole( explode( ',', $pages[$i]['roleID'] ) ) ) {
                        continue;
                    }
                }
                $active = '';
                $tabEditIco = 'none';
                $gotPage = true;
                
                if( $urlKey == $pages[$i]['pageID'] ) {
                    $active = 'active';
                    if( $Authorization->hasPermission( 'Aurora', 'edit_page' ) ) {
                        $tabEditIco = '';
                    }
                }
                $tab[] = array( 'TPLVAR_PAGE_ID'      => $pages[$i]['pageID'],
                                'TPLVAR_PAGE_TITLE'   => $pages[$i]['pageTitle'],
                                'TPLVAR_PAGE_URL'     => urlencode($pages[$i]['urlKey']),
                                'TPLVAR_ACTIVE'       => $active,
                                'TPLVAR_TAB_EDIT_ICO' => $tabEditIco,
                                'LANG_ADD_A_PAGE'     => $this->L10n->getContents('LANG_ADD_PAGE_TITLE') );
            }

            if( $Authorization->hasPermission( 'Aurora', 'create_page' ) ) {
                $vars['dynamic']['newPage'][] = true;
            }
            $vars['TPLVAR_TAB_MOVE'] = $Authorization->hasPermission( 'Aurora', 'edit_page' ) ? 'tabMove' : '';

            $vars['dynamic']['tab'] = $tab;
            return $this->render( 'aurora/page/html/tabs.tpl', $vars );
        }
    }
}
?>