<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: IdentityType.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IdentityType extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $itID ) {
        $sql = $this->DB->select( 'SELECT COUNT(itID) FROM identity_type WHERE itID = "' . (int)$itID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM identity_type', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['itID']] = $row['type'];
            }
        }
        return $list;
    }
}
?>