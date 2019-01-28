<?php
namespace Aurora\Admin;
use \Aurora\User\UserModel;
use \Aurora\Page\MenuModel, \Aurora\Page\MenuView;
use \Aurora\Page\NotificationView;
use \Library\Runtime\Registry, \View;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AdminView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdminView extends View {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $i18n;
    protected $PageRes;
    protected $UserRes;
    protected $breadcrumbs;
    protected $userInfo;


    /**
    * AdminView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->breadcrumbs = array( );
        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $this->i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );

        $this->setTitle( $this->HKEY_LOCAL['websiteName'] );
        $this->setTheme( $this->HKEY_LOCAL['theme'] );
        $this->setTplPath( TPL . 'default/' );

        $this->PageRes = $this->i18n->loadLanguage('Aurora/Page/PageRes');
        $this->UserRes = $this->i18n->loadLanguage('Aurora/User/UserRes');

        $this->userInfo = UserModel::getInstance( )->getInfo( );
        $userID = isset( $this->userInfo['userID'] ) ? '&USERID=' . (int)$this->userInfo['userID'] : '';

        $this->setJScript( array( 'aurora.noiframe' => 'aurora/aurora.noiframe.js',
                                  'jquery' => 'jquery-3.3.1.min.js',
                                  'core' => array( 'bootstrap.js', 'app.js', 'aurora.js', 'aurora.init.js.php?' .
                                                   'ROOT_URL=' . urlencode( ROOT_URL ) .
                                                   '&THEME=' . $this->HKEY_LOCAL['theme'] .
                                                   '&LANG=' . $this->i18n->getUserLang( ) . $userID ),
                                  'plugins/loaders' => array( 'blockui.min.js' ),
                                  'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                  'plugins/forms/selects' => array( 'bootstrap_multiselect.js', 'select2.min.js' ),
                                  'plugins/forms/styling' => array( 'uniform.min.js', 'switchery.min.js', 'switch.min.js' ),
                                  'plugins/notifications' => array( 'sweet_alert.min.js' ),
                                  'pages' => array( 'components_modals.js', 'components_popups.js' ),
                                  'locale' => $this->UserRes->getL10n( ) ) );

        $this->setStyle( array( 'core' => array( 'bootstrap', 'colors', 'components', 'core' ),
                                'fonts' => array( 'icomoon/styles', 'glyphicons/styles', 'material/styles' ) ) );
	}


    /**
     * Render Display View
     * @return void
     */
    public function setBreadcrumbs( array $vars ) {
        $this->breadcrumbs[] = $vars;
    }


    /**
     * Render Display View
     * @return str
     */
    public function render( $file, $vars=array( ) ) {
        $global = array( 'TPLVAR_LANG' => $this->i18n->getUserLang( ),
                         'TPLVAR_CSRF_TOKEN' => $this->Registry->get( HKEY_DYNAM, 'csrfToken' ) );

        return parent::render( $file, is_array( $vars ) ? array_merge( $vars, $global ) : $global );
    }


    /**
     * Render header
     * @return str
     */
    public function renderHeader( ) {
        return $this->render( 'aurora/core/header.tpl', $this->renderHeaderFiles( ) );
    }


    /**
     * Render header
     * @return str
     */
    public function renderNavBar( ) {
        $MenuModel = MenuModel::getInstance( );
        $MenuView = new MenuView( $MenuModel );

        $NotificationView = new NotificationView( );

        return $this->render('aurora/core/navBar.tpl',
                            array( 'TPL_MENU' => $MenuView->renderMenu( ),
                                   'TPLVAR_FNAME' => $this->userInfo['fname'],
                                   'TPLVAR_LNAME' => $this->userInfo['lname'],
                                   'TPL_NOTIFICATION_LIST' => $NotificationView->renderWindow( ) ) );
    }


    /**
     * Render header
     * @return str
     */
    public function renderSetupNavBar( ) {
        return $this->render('aurora/core/setupNavBar.tpl',
                            array( 'TPLVAR_FNAME' => $this->userInfo['fname'],
                                   'TPLVAR_LNAME' => $this->userInfo['lname'] ) );
    }


    /**
     * Render header
     * @return str
     */
    public function renderPageHeader( ) {
        $vars = array_merge( $this->PageRes->getContents( ),
            array( 'TPLVAR_AURORA_VER' => AURORA_VERSION ) );

        if( is_array( $this->breadcrumbs ) ) {
            foreach( $this->breadcrumbs as $crumbs ) {
                $active = isset( $crumbs['active'] ) ? 'active' : '';
                $icon = isset( $crumbs['icon'] ) ? $crumbs['icon'] : '';

                $vars['dynamic']['breadcrumbs'][] = array( 'TPLVAR_LINK' => $crumbs['link'],
                                                           'TPLVAR_ICON' => $icon,
                                                           'TPLVAR_ACTIVE' => $active,
                                                           'LANG_TEXT' => $crumbs['text'] );
            }
        }
        return $this->render( 'aurora/page/pageHeader.tpl', $vars );
    }


    /**
     * Render footer
     * @return str
     */
    public function renderFooter( ) {
        $vars = array( 'TPLVAR_AURORA_VERSION' => AURORA_VERSION );
        return $this->render( 'aurora/core/footer.tpl', $vars );
    }


    /**
     * Print all
     * @return void
     */
    public function printAll( $template, $setup=false ) {
        $vars = array( 'TPL_HEADER' => $this->renderHeader( ),
                       'TPL_NAV_BAR' => !$setup ? $this->renderNavBar( ) : $this->renderSetupNavBar( ),
                       'TPL_PAGE_HEADER' => !$setup ? $this->renderPageHeader( ) : '',
                       'TPL_CONTENT' => $template );

        header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
        header('Pragma: no-cache'); // HTTP 1.0.
        header('Expires: 0');
        echo $this->render( 'aurora/page/left.tpl', $vars );
    }
}
?>