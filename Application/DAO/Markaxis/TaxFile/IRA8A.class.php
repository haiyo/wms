<?php
namespace Markaxis\TaxFile;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: IRA8A.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IRA8A extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserIDTFID( $userID, $tfID ) {
        $sql = $this->DB->select( 'SELECT COUNT(*) FROM ira8a
                                   WHERE tfID = "' . (int)$tfID . '" AND 
                                         userID = "' . (int)$userID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByTFID( $tfID ) {
        $sql = $this->DB->select( 'SELECT u.*, ira.* FROM ira8a ira 
                                   LEFT JOIN user u ON ( u.userID = ira.userID )
                                   WHERE ira.tfID = "' . (int)$tfID . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $list = array( );
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
            return $list;
        }
        return false;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserIDTFID( $userID, $tfID ) {
        $sql = $this->DB->select( 'SELECT tf.*, ira.* FROM taxfile tf
                                   LEFT JOIN ira8a ira ON ( ira.tfID = tf.tfID )
                                   WHERE ira.tfID = "' . (int)$tfID . '" AND 
                                         ira.userID = "' . (int)$userID . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>