<?php
namespace Aurora\Page;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Page.class.php, v 2.0 Exp $
 */

class Page extends DAO {

    // Properties
    

    /**
    * Page Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
    }
    
    
    /**
    * Return if page is found with userID
    * @return int
    */
    public function getDefaultPage( ) {
        $sql = $this->DB->select( 'SELECT * FROM page WHERE
                                   urlKey = "dashboard"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
    * Return if page is found with userID
    * @return int
    */
    public function isFound( $pageID, $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(pageID) FROM page WHERE
                                   userID = "' . (int)$userID . '" AND
                                   pageID = "' . (int)$pageID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Return a list of all pages
    * @return mixed
    */
    public function countByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(pageID) FROM page WHERE
                                   userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }
    
    
    /**
    * Return a list of all pages
    * @return mixed
    */
    public function getAllPage( ) {
        $pages = array( );
        $sql = $this->DB->select( 'SELECT p.*, GROUP_CONCAT(pr.roleID) AS roleID FROM page p
                                   LEFT OUTER JOIN page_role pr ON(p.pageID = pr.pageID)
                                   GROUP BY p.pageID
                                   ORDER BY sorting DESC',
                                   __FILE__, __LINE__ );
                                 
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $pages[] = $row;
            }
        }
        return $pages;
    }
    

    /**
    * Retrieve Page by userID
    * @return mixed
    */
    public function getPageByUserID( $userID ) {
        $pages = array( );
        $sql = $this->DB->select( 'SELECT * FROM page WHERE
                                   userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );
                                 
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $pages[] = $row;
            }
        }
        return $pages;
    }
    
    
    /**
    * Retrieve Page by pageID
    * @return mixed
    */
    public function getPageByID( $pageID ) {
        $sql = $this->DB->select( 'SELECT * FROM page WHERE
                                   pageID = "' . (int)$pageID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
    * Retrieve Page by pageID and userID
    * @return mixed
    */
    public function getPageByIDAndUserID( $pageID, $userID, $column='*' ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM page WHERE
                                   pageID = "' . (int)$pageID . '" AND
                                   userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
    
    
    /**
    * Retrieve Page by key
    * @return mixed
    */
    public function getPageByKey( $urlKey ) {
        $sql = $this->DB->select( 'SELECT * FROM page WHERE
                                   urlKey = "' . addslashes( $urlKey ) . '"',
                                   __FILE__, __LINE__ );
                                 
        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>