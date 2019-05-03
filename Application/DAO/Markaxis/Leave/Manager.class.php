<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Manager.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Manager extends \DAO {


    // Properties


    /**
     * Manager Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByLaID( $laID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT las.managerID, las.approved, CONCAT( u.fname, \' \', u.lname ) AS name
                                   FROM leave_apply_manager las
                                   LEFT JOIN user u ON ( u.userID = las.managerID )
                                   WHERE las.laID = "' . (int)$laID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>