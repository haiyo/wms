<?php
namespace Aurora\Page;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: MenuView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MenuView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $Authorization;
    protected $MenuModel;


    /**
     * MenuView Constructor
     * @return void MessageModel $MessageModel
     */
    function __construct( \Aurora\Page\MenuModel $MenuModel ) {
        parent::__construct();
        $this->Authorization = $this->Registry->get(HKEY_CLASS, 'Authorization');

        $this->Registry = Registry::getInstance();
        $this->MenuModel = $MenuModel;

        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Aurora/NavRes');
    }


    /**
     * Get Navigation Class
     * @return string
     */
    public function getNavClass( $folder, $namespace, $className ) {
        static $nav;
        $class = $namespace . '\\' . $className;

        if (!isset($nav[$class])) {
            $Menu = new $class;
            $nav[$class] = $Menu;
        }
        return $nav[$class];
    }


    /**
     * Render account header
     * @return mixed[]
     */
    public function renderMenuChildRecursive( $menuSet ) {
        $vars = array( );

        if( is_array( $menuSet ) ) {
            foreach( $menuSet as $value ) {
                if( $value['perm'] ) {
                    if( !$this->Authorization->isAdmin( ) && !$this->Authorization->hasAnyRole( $value['perm'] ) ) {
                        continue;
                    }
                }
                $L10n = $this->i18n->loadLanguage( $value['langFile'] );

                $vars['dynamic']['secondLevel'][] = array( 'TPLVAR_URL' => $value['url'],
                                                           'TPLVAR_ICON' => $value['icon'],
                                                           'LANG_LINK' => $L10n->getContents( $value['langText'] ) );
            }
        }
        return $this->render('aurora/menu/secondLevel.tpl', $vars );
    }


    /**
     * Render account header
     * @return string
     */
    public function renderMenu( ) {
        $menuSet = $this->MenuModel->getMenu( );
        $toggle  = '';
        $vars = array( );

        foreach( $menuSet as $value ) {
            $secondMenu = '';

            if( $value['perm'] ) {
                if ( !$this->Authorization->isAdmin( ) && !$this->Authorization->hasAnyRole($value['perm'] ) ) {
                    continue;
                }
            }
            if( $value['parent'] == 0 ) {
                if( isset( $value['child'] ) ) {
                    $secondMenu = $this->renderMenuChildRecursive( $value['child'] );
                    $toggle = 'dropdown';
                }
                $L10n = $this->i18n->loadLanguage( $value['langFile'] );

                $vars['dynamic']['firstLevel'][] = array('TPLVAR_URL' => $value['url'],
                                                         'TPLVAR_ICON' => $value['icon'],
                                                         'LANG_LINK' => $L10n->getContents( $value['langText'] ),
                                                         'TPLVAR_TOGGLE' => $toggle,
                                                         'TPL_SECOND_LEVEL' => $secondMenu );
            }
        }
        return $this->render('aurora/menu/firstLevel.tpl', $vars );
    }
}
?>