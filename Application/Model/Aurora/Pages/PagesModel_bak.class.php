<?php
namespace Aurora\Pages;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PagesModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PagesModel extends \Model {


    // Properties
    protected $roleInfo;

    
    /**
    * PagesModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->info['pageID']    = 0;
        $this->info['pageTitle'] = '';
        $this->info['urlKey']    = '';
        $this->info['perm']      = 1;
        $this->info['layout']    = 'left';
        $this->info['droplets']  = '';
	}
    
    
    /**
    * Get Default Page Info
    * @return bool
    */
    public function getDefaultPage( ) {
        File::import( DAO . 'Aurora/Page/Page.class.php' );
        $Page = new Page( );
        return $Page->getDefaultPage( );
    }


    /**
    * Load a Page Information
    * @return bool
    */
    public function loadPageInfo( $pageID ) {
        File::import( DAO . 'Aurora/Page/Page.class.php' );
        $Page = new Page( );
        $this->info = $Page->getPageByID( $pageID );

        if( $this->info ) return true;
        return false;
    }


    /**
    * Load a Page Information
    * @return bool
    */
    public function isFoundByUserID( $userID ) {
        File::import( DAO . 'Aurora/Page/Page.class.php' );
        $Page = new Page( );
        return $Page->countByUserID( $userID );
    }
    
    
    /**
    * Set pageInfo Property
    * @return mixed
    */
    public function setPageInfo( $info ) {
        $this->info['pageID']    = (int)$info['pageID'];
        $this->info['droplets']  = $info['droplets'];
        $this->info['pageTitle'] = htmlspecialchars( trim( urldecode( $info['pageTitle'] ) ) );
        if( $this->info['pageTitle'] == '' ) { echo 0; exit; }

        $this->info['urlKey'] = str_replace( ' ', '_',   strtolower( $this->info['pageTitle'] ) );
        $this->info['urlKey'] = str_replace( '&', 'and', $this->info['urlKey'] );
        $this->info['urlKey'] = preg_replace( '/[^a-z0-9]/i', '', $this->info['urlKey'] );

        if( in_array( $info['layout'], PageLayoutHelper::getList( ) ) ) {
            $this->info['layout'] = $info['layout'];

            // Rearrange droplets if the page layout changes
            $droplets = explode( '|', $this->info['droplets'] );
            
            if( $this->info['layout'] == 'full' ) {
                $this->info['droplets'] = implode( ',', $droplets );
            }
            else if( $this->info['layout'] == 'left' || $this->info['layout'] == 'right' ||
                     $this->info['layout'] == 'two' || $this->info['layout'] == 'left4' ) {
                if( isset( $droplets[2] ) && $droplets[2] != '' ) {
                    $this->info['droplets'] = $droplets[0]. '|' . $droplets[1] . ',' . $droplets[2];
                }
            }
        }

        // Dashboard don't change permission
        if( $this->info['pageID'] != 1 && $info['perm'] < 4 ) {
            $this->info['perm'] = $info['perm'];
            if( $this->info['perm'] == 3 && isset( $info['roles'] ) ) {
                $this->roleInfo = $info['roles'];
            }
        }
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        $this->info['userID'] = $userInfo['userID'];
        return true;
    }


    /**
    * Save Page
    * @return bool
    */
    public function save( ) {
        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );

        if( $this->info['pageID'] > 0 ) {
            // Only the Creator or Administrator may edit the page
            if( $this->isFoundByUserID( $this->info['userID'] ) || $Authorization->isAdmin( ) ) {
                $this->editPage( );
                $this->deletePageRoles( );
            }
            else {
                throw( new NoPermissionException( 'UserID: ' . $this->info['userID'] . '; ' .
                                                  'Trying to perform edit on PageID: ' . $this->info['pageID'] ) );
            }
        }
        else {
            if( $Authorization->hasPermission( 'aurora', 'create_page' ) || $Authorization->isAdmin( ) ) {
                $this->info['pageID'] = $this->addPage( );
            }
            else {
                throw( new NoPermissionException( 'UserID: ' . $this->info['userID'] . '; ' .
                                                  $Authorization->getLastOperation( ) ) );
            }
        }
        if( in_array( $this->info['perm'], PermHelper::getList( ) ) && is_array( $this->roleInfo ) ) {
            foreach( $this->roleInfo as $roleID ) {
                if( is_numeric( $roleID ) ) {
                    $this->addPageRoles( $roleID );
                }
            }
        }
    }


    /**
    * Add a New Page
    * @return bool
    */
    public function addPage( ) {
        File::import( DAO . 'Aurora/DAO.class.php' );
        $DAO = new DAO( );
        return $DAO->insert( 'page', $this->info );
    }


    /**
    * Add a New Page
    * @return bool
    */
    public function editPage( ) {
        File::import( DAO . 'Aurora/DAO.class.php' );
        $DAO = new DAO( );
        return $DAO->update( 'page', $this->info, 'WHERE pageID="' . (int)$this->info['pageID'] . '"' );
    }


    /**
    * Delete a Page
    * @return bool
    */
    public function deletePage( ) {
        if( $this->info['pageID'] != 1 ) {
            $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            // Only the Creator or Administrator may delete the page
            if( $this->info['userID'] == $userInfo['userID'] || $Authorization->isAdmin( ) ) {
                File::import( DAO . 'Aurora/DAO.class.php' );
                $DAO = new DAO( );
                return $DAO->delete( 'page', 'WHERE pageID="' . (int)$this->info['pageID'] . '"' );
                // Page roles deleted automatically by foreign key
            }
            else {
                throw( new NoPermissionException( 'UserID: ' . $userInfo['userID'] . '; ' .
                                                  'Trying to perform delete on PageID: ' . $pageID ) );
            }
        }
    }


    /**
    * Returns all Roles from a Page
    * @return bool
    */
    public function getPageRoles( $pageID ) {
        File::import( DAO . 'Aurora/PageRole.class.php' );
        $PageRole = new PageRole( );
        return $PageRole->getPageRoles( $pageID );
    }


    /**
    * Load a Page Information
    * @return bool
    */
    public function addPageRoles( $roleID ) {
        File::import( DAO . 'Aurora/PageRole.class.php' );
        $PageRole = new PageRole( );
        $info = array( );
        $info['pageID'] = (int)$this->info['pageID'];
        $info['roleID'] = (int)$roleID;
        return $PageRole->insert( 'page_role', $info );
    }


    /**
    * Delete All Roles from a Page
    * @return bool
    */
    public function deletePageRoles( ) {
        File::import( DAO . 'Aurora/PageRole.class.php' );
        $PageRole = new PageRole( );
        return $PageRole->delete( 'page_role', 'WHERE pageID="' . (int)$this->info['pageID'] . '"' );
    }
}
?>