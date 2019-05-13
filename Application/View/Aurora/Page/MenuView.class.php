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
     * @return string
     */
    public function renderMenuChildRecursive( $menuSet ) {
        $vars = array( );

        if( is_array( $menuSet ) ) {
            foreach( $menuSet as $value ) {
                if( !$value['perms'] ) {
                    continue;
                }
                $actions = explode( ',', $value['perms'] );

                foreach( $actions as $namespace_action ) {
                    $perm = explode( '.', $namespace_action );

                    if( !$this->Authorization->hasPermission( $perm[0], $perm[1] ) ) {
                        continue 2;
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
        $vars = $menu = array( );

        foreach( $menuSet as $value ) {
            $secondMenu = '';

            if( !$value['perms'] ) {
                continue;
            }
            $actions = explode( ',', $value['perms'] );

            foreach( $actions as $namespace_action ) {
                $perm = explode( '.', $namespace_action );

                if( !$this->Authorization->hasPermission( $perm[0], $perm[1] ) ) {
                    continue 2;
                }
            }

            $L10n = $this->i18n->loadLanguage( $value['langFile'] );

            if( $value['parent'] == 0 ) {
                $menu[$value['id']] = array('TPLVAR_URL' => $value['url'],
                                            'TPLVAR_ICON' => $value['icon'],
                                            'LANG_LINK' => $L10n->getContents( $value['langText'] ),
                                            'TPL_SECOND_LEVEL' => '' );
            }
            else if( isset( $menu[$value['parent']] ) ) {
                $childVars = array( 'TPLVAR_URL' => $value['url'],
                                    'TPLVAR_ICON' => $value['icon'],
                                    'LANG_LINK' => $L10n->getContents( $value['langText'] ) );

                $menu[$value['parent']]['TPL_SECOND_LEVEL'] .= $this->render('aurora/menu/secondLevel.tpl', $childVars );
            }
        }

        if( sizeof( $menu ) > 0 ) {
            foreach( $menu as $links ) {
                $toggle = $toggleClass = '';

                if( $links['TPL_SECOND_LEVEL'] ) {
                    $toggle = 'dropdown';
                    $toggleClass = 'nav-dropdown-toggle';
                }
                $vars['dynamic']['firstLevel'][] = array('TPLVAR_URL' => $links['TPLVAR_URL'],
                                                         'TPLVAR_ICON' => $links['TPLVAR_ICON'],
                                                         'LANG_LINK' => $links['LANG_LINK'],
                                                         'TPLVAR_TOGGLE' => $toggle,
                                                         'TPLVAR_TOGGLE_CLASS' => $toggleClass,
                                                         'TPL_SECOND_LEVEL' => $links['TPL_SECOND_LEVEL'] );
            }
        }

        return $this->render('aurora/menu/firstLevel.tpl', $vars );
    }
}
?>