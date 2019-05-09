<?php
namespace Aurora\User;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RolePermView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RolePermView extends AdminView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $L10n;
    protected $RolePermModel;
    protected $PermissionModel;


    /**
    * RolePermView Constructor
    * @return void
    */
    function __construct( RolePermModel $RolePermModel, PermissionModel $PermissionModel ) {
        parent::__construct();

        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $this->RolePermModel = $RolePermModel;
        $this->PermissionModel = $PermissionModel;

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/RolePermRes');
	}


    /**
     * Render main navigation
     * @return string
     */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/rolePerm/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'LANG_LINK' => $this->L10n->getContents('LANG_ROLES_PERMISSIONS') );

        /*
        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
        if( $Authorization->hasPermission( 'Aurora', 'change_logo' ) ) {
            $vars['dynamic']['logoTools'][] = true;
        }*/

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }


    /**
    * Render Role List
    * @return string
    */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( ) );

        /*$roleList = $this->RolePermModel->getAll( );
        $sizeof   = sizeof( $roleList );

        $vars['dynamic']['roleList'] = false;

        if( $sizeof > 0 ) {
            for( $i=0; $i<$sizeof; $i++ ) {
                $vars['dynamic']['roleList'][] = array( 'TPLVAR_ROLE_ID'       => $roleList[$i]['roleID'],
                                                        'TPLVAR_ROLE_TITLE'    => $roleList[$i]['title'],
                                                        'TPLVAR_ROLE_DESCRIPT' => $roleList[$i]['descript'] );
            }
        }

        $vars['TPL_PERM_LIST'] = $this->renderPermList( );
        $this->setBreadcrumbs( array( 'link' => '', 'text' => $this->L10n->getContents('LANG_ROLES_PERMISSIONS') ) );*/
        return $this->render( 'markaxis/employee/roleList.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderPerms( $roleID ) {
        $userInfo = $this->PayrollModel->getCalculateUserInfo( $roleID );

        $roleList = $this->RolePermModel->getAll( );
        $sizeof   = sizeof( $roleList );

        $vars['dynamic']['roleList'] = false;

        if( $sizeof > 0 ) {
            for( $i=0; $i<$sizeof; $i++ ) {
                $vars['dynamic']['roleList'][] = array( 'TPLVAR_ROLE_ID'       => $roleList[$i]['roleID'],
                                                        'TPLVAR_ROLE_TITLE'    => $roleList[$i]['title'],
                                                        'TPLVAR_ROLE_DESCRIPT' => $roleList[$i]['descript'] );
            }
        }
        $vars['TPL_PERM_LIST'] = $this->renderPermList( );
        return $this->render( 'markaxis/employee/roleList.tpl', $vars );
    }


    /**
    * Render Role List
    * @return string
    */
    public function renderPermList( ) {
        $permList = $this->PermissionModel->getAll( );
        $sizeof = sizeof( $permList );
        $list = array( );

        for( $i=0; $i<$sizeof; $i++ ) {
            $vars = array( 'TPLVAR_PERM_ID'       => $permList[$i]['permID'],
                           'TPLVAR_PARENT_ID'     => $permList[$i]['parentID'],
                           'TPLVAR_PERM_TITLE'    => $permList[$i]['title'],
                           'TPLVAR_PERM_DESCRIPT' => $permList[$i]['descript'] );

            if( $permList[$i]['parentID'] == 0 ) {
                $list[$permList[$i]['permID']] = $this->render( 'aurora/role/permGroup.tpl', $vars );
            }
            else {
                $list[$permList[$i]['parentID']] .= $this->render( 'aurora/role/permList.tpl', $vars );
            }
        }
        $vars['TPL_PERM_LIST'] = implode( '', array_values( $list ) );
        return $this->render( 'markaxis/employee/permList.tpl', $vars );
    }
}
?>