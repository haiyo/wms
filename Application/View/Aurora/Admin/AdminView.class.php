<?php
namespace Aurora\Admin;
use \Aurora\User\UserImageModel;
use \Markaxis\Company\CompanyModel, Markaxis\Employee\EmployeeModel;
use \Aurora\Component\DesignationModel, \Aurora\Component\OfficeModel, \Aurora\Page\MenuView;
use \Library\Helper\HTMLHelper, \Aurora\Notification\NotificationView;
use \Library\Helper\SingletonHelper, \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AdminView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdminView extends SingletonHelper {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $i18n;
    protected $GlobalRes;
    protected $PageRes;
    protected $UserRes;
    protected $breadcrumbs;
    protected $headerLinks;
    protected $userInfo;
    protected $tplPath;
    protected $title;
    protected $theme;
    protected $js;
    protected $css;


    /**
    * AdminView Constructor
    * @return void
    */
    function __construct( ) {
        $this->breadcrumbs = array( );
        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $this->i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );

        $this->setTitle( $this->HKEY_LOCAL['websiteName'] );
        $this->setTheme( $this->HKEY_LOCAL['theme'] );
        $this->setTplPath( TPL . 'default/' );

        $this->GlobalRes = $this->i18n->loadLanguage('Aurora/GlobalRes');
        $this->PageRes = $this->i18n->loadLanguage('Aurora/Page/PageRes');
        $this->UserRes = $this->i18n->loadLanguage('Aurora/User/UserRes');

        $EmployeeModel = EmployeeModel::getInstance( );
        $this->userInfo = $EmployeeModel->getInfo( );

        $userID = isset( $this->userInfo['userID'] ) ? '&USERID=' . (int)$this->userInfo['userID'] : '';

        $OfficeModel = OfficeModel::getInstance( );
        $officeInfo = $OfficeModel->getMainOffice( );

        $currencyCode = isset( $officeInfo['currencyCode'] ) ? $officeInfo['currencyCode'] : 'SGD';
        $currencySymbol = isset( $officeInfo['currencySymbol'] ) ? $officeInfo['currencySymbol'] : '$';

        $this->setJScript( array( 'aurora.noiframe' => 'aurora/aurora.noiframe.js',
                                  'jquery' => array( 'jquery-3.3.1.min.js', 'jquery-migrate-3.0.0.min.js' ),
                                  'core' => array( 'bootstrap.js', 'app.js', 'aurora.js', 'notification.js',
                                                   'aurora.init.js.php?ROOT_URL=' . urlencode( ROOT_URL ) .
                                                   '&THEME=' . $this->HKEY_LOCAL['theme'] .
                                                   '&LANG=' . $this->i18n->getUserLang( ) .
                                                   '&currency=' . $currencyCode .
                                                   $currencySymbol . $userID ),
                                  'plugins/loaders' => array( 'blockui.min.js' ),
                                  'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                  'plugins/forms/selects' => array( 'bootstrap_multiselect.js', 'select2.min.js' ),
                                  'plugins/forms/styling' => array( 'uniform.min.js', 'switchery.min.js', 'switch.min.js' ),
                                  'plugins/notifications' => array( 'sweet_alert.min.js' ),
                                  'pages' => array( 'components_modals.js', 'components_popups.js', 'support.js' ),
                                  'plugins/uploaders' => array( 'fileinput.min.js' ),
                                  'locale' => array( $this->GlobalRes->getL10n( ), $this->UserRes->getL10n( ) ) ) );

        $this->setStyle( array( 'core' => array( 'bootstrap', 'colors', 'components', 'core' ),
                                'fonts' => array( 'proxima/styles', 'icomoon/styles', 'glyphicons/styles', 'material/styles' ) ) );
	}


    /**
     * Render Display View
     * @return mixed
     */
    public function getGlobalRes( ) {
        return $this->GlobalRes;
    }


    /**
     * Render Display View
     * @return void
     */
    public function setHeaderLinks( array $vars ) {
        $this->headerLinks[] = $vars;
    }


    /**
     * Render Display View
     * @return void
     */
    public function setBreadcrumbs( array $vars ) {
        $this->breadcrumbs[] = $vars;
    }


    /**
     * Set Template Path
     * @return void
     */
    public function setTplPath( $path ) {
        if( is_dir( $path ) ) {
            $this->tplPath = (string)$path;
        }
        else die( 'Template path cannot be found: ' . $path );
    }


    /**
     * Set title
     * @return void
     */
    public function setTitle( $title ) {
        $this->title = (string)$title;
    }


    /**
     * Set theme
     * @return void
     */
    public function setTheme( $theme ) {
        $this->theme = (string)$theme;
    }


    /**
     * Set JavaScript
     * @return void
     */
    public function setJScript( array $jScript ) {
        foreach( $jScript as $namespace => $js ) {
            if( is_array( $js ) ) {
                // Multiple js from the same namespace
                foreach( $js as $jsFile ) {
                    if( !in_array($namespace . '/' . $jsFile, $this->js ) ) {
                        $this->js[] = $namespace . '/' . $jsFile;
                    }
                }
            }
            else {
                $this->js[] = $namespace . '/' . $js;
            }
        }
    }


    /**
     * Set CSS Stylesheet
     * @return void
     */
    public function setStyle( array $cssStyle ) {
        foreach( $cssStyle as $namespace => $css ) {
            if( is_array( $css ) ) {
                // Multiple css from the same namespace
                foreach( $css as $cssFile ) {
                    $this->css[] = $namespace . '/' . $cssFile;
                }
            }
            else {
                $this->css[] = $namespace . '/' . $css;
            }
        }
    }


    /**
     * Render Display View
     * @return string
     */
    public function render( $file, $vars=array( ) ) {
        $TPL = new HTMLHelper( $this->tplPath );
        $TPL->define( array( 'template' => $file ) );

        if( isset( $vars['dynamic'] ) ) {
            foreach( $vars['dynamic'] as $key => $value ) {
                $TPL->defineDynamic( $key, 'template' );

                if( is_array( $value ) && sizeof( $value ) == 0 || $value == false ) {
                    $TPL->clearDynamic( $key );
                }
                else if( !is_array( $value ) && $value == true ) {
                    $TPL->parse( "ROW$key", ".$key" );
                }
                else {
                    foreach( $value as $dynamicVars ) {
                        $TPL->assign( $dynamicVars );
                        $TPL->parse( "ROW$key", ".$key" );
                    }
                }
            }
            unset( $vars['dynamic'] );
        }
        $global = array_merge( $this->GlobalRes->getContents( ),
                  array( 'TPLVAR_ROOT_URL' => ROOT_URL,
                         'TPLVAR_TITLE'  => $this->title,
                         'TPLVAR_THEME'  => $this->theme,
                         'TPLVAR_LANG' => $this->i18n->getUserLang( ),
                         'TPLVAR_CSRF_TOKEN' => $this->Registry->get( HKEY_DYNAM, 'csrfToken' ) ) );

        if( is_array( $vars ) ) {
            $TPL->assign( array_merge( $vars, $global ) );
        }
        else {
            $TPL->assign( $global );
        }
        $TPL->parse( 'ALL', 'template' );
        return $TPL->fetch('ALL');
    }


    /**
     * Render header
     * @return mixed
     */
    public function renderHeaderFiles( ) {
        $vars = array( );
        if( sizeof( $this->js ) > 0 ) {
            foreach( $this->js as $jname ) {
                $jsLoad[] = array( 'TPLVAR_ROOT_URL' => ROOT_URL,
                                   'TPLVAR_JNAME'    => $jname );
            }
            $vars['dynamic']['jsRow'] = $jsLoad;
        }
        if( is_array( $this->css ) ) {
            foreach( $this->css as $cssname ) {
                $cssLoad[] = array( 'TPLVAR_ROOT_URL' => ROOT_URL,
                                    'TPLVAR_CSSNAME'  => $cssname,
                                    'TPLVAR_MICRO' => MD5(microtime( ) ) );
            }
            $vars['dynamic']['cssRow'] = $cssLoad;
        }
        return $vars;
    }


    /**
     * Render header
     * @return string
     */
    public function renderHeader( ) {
        return $this->render( 'aurora/core/header.tpl', $this->renderHeaderFiles( ) );
    }


    /**
     * Render header
     * @return string
     */
    public function renderNavBar( ) {
        $MenuView = new MenuView( );
        $NotificationView = new NotificationView( );

        $CompanyModel = CompanyModel::getInstance( );
        $companyInfo = $CompanyModel->getInfo( );

        $DesignationModel = DesignationModel::getInstance( );
        $designation = $DesignationModel->getByID( $this->userInfo['designationID'] )['title'];

        $UserImageModel = UserImageModel::getInstance( );
        $startDate = date('M Y', strtotime( $this->userInfo['startDate'] ) );

        return $this->render('aurora/core/navBar.tpl',
                              array_merge( $this->UserRes->getContents( ),
                                           $this->PageRes->getContents( ),
                              array( 'TPL_MENU' => $MenuView->renderMenu( ),
                                   'TPLVAR_PHOTO' => $UserImageModel->getImgLinkByUserID( $this->userInfo['userID'] ),
                                   'TPLVAR_FNAME' => $this->userInfo['fname'],
                                   'TPLVAR_LNAME' => $this->userInfo['lname'],
                                   'TPLVAR_DESIGNATION' => $designation,
                                   'TPLVAR_START_DATE' => $startDate,
                                   'TPLVAR_MAIN_COLOR' => $companyInfo['mainColor'],
                                   'TPLVAR_NAVIGATION_COLOR' => $companyInfo['navigationColor'],
                                   'TPLVAR_NAVIGATION_TEXT_COLOR' => $companyInfo['navigationTextColor'],
                                   'TPLVAR_NAVIGATION_TEXT_HOVER_COLOR' => $companyInfo['navigationTextHoverColor'],
                                   'TPLVAR_BUTTON_COLOR' => $companyInfo['buttonColor'],
                                   'TPLVAR_BUTTON_HOVER_COLOR' => $companyInfo['buttonHoverColor'],
                                   'TPLVAR_BUTTON_FOCUS_COLOR' => $companyInfo['buttonFocusColor'],
                                   'TPL_NOTIFICATION_WINDOW' => $NotificationView->renderWindow( ) ) ) );
    }


    /**
     * Render header
     * @return string
     */
    public function renderSetupNavBar( ) {
        return $this->render('aurora/core/setupNavBar.tpl',
                            array( 'TPLVAR_FNAME' => $this->userInfo['fname'],
                                   'TPLVAR_LNAME' => $this->userInfo['lname'] ) );
    }


    /**
     * Render header
     * @return string
     */
    public function renderPageHeader( ) {
        $vars = array_merge( $this->PageRes->getContents( ),
                array( 'TPLVAR_AURORA_VER' => AURORA_VERSION ) );

        $vars['dynamic']['breadcrumbs'] = false;

        if( is_array( $this->breadcrumbs ) ) {
            foreach( $this->breadcrumbs as $crumb ) {
                $active = isset( $crumb['active'] ) ? 'active' : '';
                $icon = isset( $crumb['icon'] ) ? $crumb['icon'] : '';

                $vars['dynamic']['breadcrumbs'][] = array( 'TPLVAR_LINK' => $crumb['link'],
                                                           'TPLVAR_ICON' => $icon,
                                                           'TPLVAR_ACTIVE' => $active,
                                                           'LANG_TEXT' => $crumb['text'] );
            }
        }

        if( is_array( $this->headerLinks ) ) {
            foreach( $this->headerLinks as $link ) {
                $vars['dynamic']['headerLinks'][] = array( 'TPLVAR_LINK' => $link['link'],
                                                           'TPLVAR_ICON' => $link['icon'],
                                                           'TPLVAR_CLASSNAME' => $link['classname'],
                                                           'TPLVAR_DATA_TOGGLE' => $link['toggle'],
                                                           'TPLVAR_DATA_TARGET' => $link['target'],
                                                           'LANG_TEXT' => $link['text'] );
            }
        }

        $vars['dynamic']['headerLinks'][] = array( 'TPLVAR_LINK' => '#',
                                                   'TPLVAR_ICON' => 'icon-lifebuoy',
                                                   'TPLVAR_CLASSNAME' => '',
                                                   'TPLVAR_DATA_TOGGLE' => 'modal',
                                                   'TPLVAR_DATA_TARGET' => 'modalSupport',
                                                   'LANG_TEXT' => $this->PageRes->getContents('LANG_FOUND_ISSUE') );

        return $this->render('aurora/page/pageHeader.tpl', $vars );
    }


    /**
     * Render footer
     * @return string
     */
    public function renderFooter( ) {
        $vars = array( 'TPLVAR_AURORA_VERSION' => AURORA_VERSION );
        return $this->render('aurora/core/footer.tpl', $vars );
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

        $content = $this->render('aurora/page/left.tpl', $vars );

        header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
        header('Expires: 0');
        header('Content-length: ' . strlen( $content ) );
        echo $content;
    }
}
?>