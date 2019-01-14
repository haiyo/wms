<?php
use Library\Helper\SingletonHelper, \Library\Helper\HTMLHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, July 7th, 2012
 * @version $Id: View.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class View extends SingletonHelper {


    // Properties
    // NOTE: Only for CSS override usage, NOT template. So as third-party classes
    // may load their own CSS theme folder.
    protected $Registry;
    protected $i18n;
    protected $tplPath;
    protected $title;
    protected $theme;
    protected $js;
    protected $css;


    /**
    * View Constructor
    * @return void
    */
    function __construct( ) {
        $this->js = array( );
        $this->Registry = Registry::getInstance( );
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
                    $this->js[] = $namespace . '/' . $jsFile;
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
    * @return void
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
        $global = array( 'TPLVAR_ROOT_URL' => ROOT_URL,
                         'TPLVAR_TITLE'    => $this->title,
                         'TPLVAR_THEME'    => $this->theme );

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
    * @return str
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
    * @return str
    */
    public function renderHeader( ) {
        return $this->render( 'core/header.tpl', $this->renderHeaderFiles( ) );
    }


    /**
    * Render navigation
    * @return str
    */
    public function renderNav( ) {
        return $this->render( 'core/headerNav.tpl', array( ) );
    }


    /**
    * Render footer
    * @return str
    */
    public function renderFooter( ) {
        $vars = array( 'TPLVAR_AURORA_VERSION' => AURORA_VERSION );
        return $this->render( 'core/footer.tpl', $vars );
    }
}
?>