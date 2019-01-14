<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Supervisor.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Supervisor extends \DAO {


    // Properties


    /**
     * Supervisor Constructor
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

        $sql = $this->DB->select( 'SELECT las.supUserID, las.approved, CONCAT( u.fname, \' \', u.lname ) AS name
                                   FROM leave_apply_supervisor las
                                   LEFT JOIN user u ON ( u.userID = las.supUserID )
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