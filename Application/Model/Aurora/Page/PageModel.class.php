<?php
namespace Aurora\Page;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageModel extends \Model {


    // Properties


    /**
    * PageModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Retrieve a Page Information
    * @return mixed
    */
    public function getPageInfo( $pageID ) {
        File::import( DAO . 'Aurora/Page.class.php' );
        $Page = new Page( );
        $pageInfo = $Page->getPageByID( $pageID );

        if( $pageInfo ) {
            if( $pageInfo['perm'] == 3 ) {
                File::import( DAO . 'Aurora/PageRole.class.php' );
                $PageRole = new PageRole( );
                $pageInfo['pageRoles'] = $PageRole->getPageRoles( $pageInfo['pageID'] );
            }

            return $pageInfo;
        }
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
    * Return a list of all pages
    * @return mixed
    */
    public function getAllPage( ) {
        File::import( DAO . 'Aurora/Page.class.php' );
        $Page = new Page( );
        return $Page->getAllPage( );
    }


    /**
    * Save Page Droplets
    * @return bool
    */
    public function saveDroplets( $page, $droplets ) {
        $page = pathinfo( $page );
        File::import( DAO . 'Aurora/Page.class.php' );
        $Page = new Page( );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( is_numeric( $page['basename'] ) && $Page->isFound( $page['basename'], $userInfo['userID'] ) ) {
            $sortList = '';
            $droplets = explode( '|', $droplets );

            if( sizeof( $droplets ) > 0 ) {
                while( list( , $value ) = each( $droplets ) ) {
                    $sortList .= substr( $value, 0, -1 ) . '|';
                }
                $sortList = substr( $sortList, 0, -1 );
            }

            $info = array( );
            $info['droplets'] = $sortList;
            return $Page->update( 'page', $info, 'WHERE userID = "' . (int)$userInfo['userID'] . '" AND
                                                        pageID = "' . (int)$page['basename'] . '"' );
        }
        return 0;
    }


    /**
    * Save Page Sorting
    * @return bool
    */
    public function saveSorting( $post ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        File::import( DAO . 'Aurora/Page.class.php' );
        $Page = new Page( );

        $post = explode( '=', $post['sorting'] );
        $i=0;
        while( list( , $pageID ) = each( $post ) ) {
            $info = array( );
            $info['sorting'] = $i;
            $Page->update( 'page', $info, 'WHERE userID = "' . (int)$userInfo['userID'] . '" AND
                                                 pageID = "' . (int)$pageID . '"' );
            $i++;
        }

        return true;
    }


    /**
    * Remove Droplet from Page
    * @return bool
    */
    public function removeDroplet( $dropletID ) {
        $pageID = pathinfo( $_SERVER['HTTP_REFERER'] );
        $pageID = str_replace( '/', '', $pageID['basename'] );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        File::import( DAO . 'Aurora/Page.class.php' );
        $Page = new Page( );

        if( $pageInfo = $Page->getPageByIDAndUserID( $pageID, $userInfo['userID'], 'droplets' ) ) {
            $info = array( );
            $info['droplets'] = str_replace( $dropletID . ',', '', $pageInfo['droplets'] );
            $info['droplets'] = str_replace( ',' . $dropletID, '', $info['droplets'] );
            $info['droplets'] = str_replace( $dropletID,       '', $info['droplets'] );

            $Page->update( 'page', $info, 'WHERE pageID="' . (int)$pageID . '"' );
            $Page->delete( 'droplet_setting', 'WHERE dropletID="' . addslashes( $dropletID ) . '"' );
            return true;
        }
    }
}
?>