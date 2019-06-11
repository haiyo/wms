<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: State.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class State extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $sID ) {
        $sql = $this->DB->select( 'SELECT COUNT(sID) FROM state WHERE sID = "' . (int)$sID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( $cID ) {
        $sql = $this->DB->select( 'SELECT * FROM state WHERE country = "' . (int)$cID . '"', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = array( 'id' => $row['sID'], 'text' => $row['name'] );
            }
        }
        return $list;
    }
}
?>