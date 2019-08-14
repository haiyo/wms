<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Contract.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Contract extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $lgID, $cID ) {
        $sql = $this->DB->select( 'SELECT COUNT(lcID) FROM leave_contract
                                   WHERE lgID = "' . (int)$lgID . '" AND
                                         cID = "' . (int)$cID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByID( $lgID, $cID ) {
        $sql = $this->DB->select( 'SELECT * FROM leave_contract 
                                   WHERE lgID = "' . (int)$lgID . '" AND
                                         cID = "' . (int)$cID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getBylgID( $lgID ) {
        $sql = $this->DB->select( 'SELECT lc.*, c.type
                                   FROM leave_contract lc
                                   LEFT JOIN contract c ON ( c.cID = lc.cID )
                                   WHERE lgID = "' . (int)$lgID . '"',
                                   __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['cID']] = $row;
            }
        }
        return $list;
    }
}
?>