<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Education.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Education extends \DAO {


    // Properties


    /**
     * Education Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $eduID ) {
        $sql = $this->DB->select( 'SELECT COUNT(eduID) FROM employee_education 
                                   WHERE eduID = "' . (int)$eduID . '" AND userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUID( $eduID, $uID ) {
        $sql = $this->DB->select( 'SELECT COUNT(eduID) FROM employee_education 
                                   WHERE eduID = "' . (int)$eduID . '" AND certificate = "' . (int)$uID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getByUserID( $userID, $column ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM employee_education
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getByEduID( $eduID, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM employee_education
                                   WHERE eduID = "' . (int)$eduID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>