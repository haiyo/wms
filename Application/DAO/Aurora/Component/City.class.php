<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: City.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class City extends \DAO {


    // Properties


    /**
     * City Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        $sql = $this->DB->select( 'SELECT COUNT(cID) FROM city WHERE cID = "' . (int)$cID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( $sID ) {
        $sql = $this->DB->select( 'SELECT * FROM city WHERE state = "' . (int)$sID . '"', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = array( 'id' => $row['cID'], 'text' => $row['name'] );

            }
        }
        return $list;
    }
}
?>