<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Office.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Office extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $oID ) {
        $sql = $this->DB->select( 'SELECT COUNT(oID) FROM office 
                                   WHERE oID = "' . (int)$oID . '" AND
                                         deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getByoID( $oID ) {
        $sql = $this->DB->select( 'SELECT *, o.name AS officeName,
                                   TIME_FORMAT( openTime, "%l:%i %p" ) AS openTime, 
                                   TIME_FORMAT( closeTime, "%l:%i %p" ) AS closeTime
                                   FROM office o
                                   LEFT JOIN office_type ot ON ( ot.otID = o.officeTypeID )
                                   LEFT JOIN country c ON ( c.cID = o.countryID )
                                   WHERE oID = "' . (int)$oID . '" AND
                                         o.deleted <> "1"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getMainOffice( ) {
        $sql = $this->DB->select( 'SELECT *, o.name AS officeName FROM office o
                                   LEFT JOIN office_type ot ON ( ot.otID = o.officeTypeID )
                                   LEFT JOIN country c ON ( c.cID = o.countryID )
                                   WHERE main = "1" AND
                                         o.deleted <> "1"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM office WHERE deleted <> "1"',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['oID']] = $row;
            }
        }
        return $list;
    }
}
?>