<?php
namespace Aurora\Page;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageModel extends \Model {


    // Properties
    protected $Page;


    /**
    * PageModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Page = new Page( );
    }


    /**
    * Retrieve a Page Information
    * @return mixed
    */
    public function getPageInfo( $pageID ) {
        $pageInfo = $this->Page->getPageByID( $pageID );

        if( $pageInfo ) {
            if( $pageInfo['perm'] == 3 ) {
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
        return $this->Page->getDefaultPage( );
    }


    /**
    * Return a list of all pages
    * @return mixed
    */
    public function getAllPage( ) {
        return $this->Page->getAllPage( );
    }


    /**
    * Save Page Droplets
    * @return bool
    */
    public function saveDroplets( $page, $droplets ) {
        $page = pathinfo( $page );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( is_numeric( $page['basename'] ) && $this->Page->isFound( $page['basename'], $userInfo['userID'] ) ) {
            $sortList = '';
            $droplets = explode( '|', $droplets );

            if( sizeof( $droplets ) > 0 ) {
                foreach( $droplets as $value ) {
                    $sortList .= substr( $value, 0, -1 ) . '|';
                }
                $sortList = substr( $sortList, 0, -1 );
            }

            $info = array( );
            $info['droplets'] = $sortList;
            return $this->Page->update( 'page', $info, 'WHERE userID = "' . (int)$userInfo['userID'] . '" AND
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

        $post = explode( '=', $post['sorting'] );
        $i=0;
        foreach( $post as $pageID ) {
            $info = array( );
            $info['sorting'] = $i;
            $this->Page->update( 'page', $info, 'WHERE userID = "' . (int)$userInfo['userID'] . '" AND
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

        if( $pageInfo = $this->Page->getPageByIDAndUserID( $pageID, $userInfo['userID'], 'droplets' ) ) {
            $info = array( );
            $info['droplets'] = str_replace( $dropletID . ',', '', $pageInfo['droplets'] );
            $info['droplets'] = str_replace( ',' . $dropletID, '', $info['droplets'] );
            $info['droplets'] = str_replace( $dropletID,       '', $info['droplets'] );

            $this->Page->update( 'page', $info, 'WHERE pageID="' . (int)$pageID . '"' );
            $this->Page->delete( 'droplet_setting', 'WHERE dropletID="' . addslashes( $dropletID ) . '"' );
            return true;
        }
    }
}
?>