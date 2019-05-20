<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Currency.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Currency extends \DAO {


    // Properties


    /**
     * Currency Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        $sql = $this->DB->select( 'SELECT COUNT(cID) FROM currency WHERE cID = "' . (int)$cID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM currency', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['cID']] = $row['code'] . $row['symbol'];
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getListAll( ) {
        $sql = $this->DB->select( 'SELECT * FROM currency', __FILE__, __LINE__ );

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