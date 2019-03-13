<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Item.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Item extends \DAO {


    // Properties


    /**
     * Item Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $piID ) {
        $sql = $this->DB->select( 'SELECT COUNT(piID) FROM payroll_item WHERE piID = "' . (int)$piID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT piID AS id, title
                                   FROM payroll_item
                                   ORDER BY title', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['id']] = $row['title'];
            }
        }
        return $list;
    }
}
?>