<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ItemTax.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemTax extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBypiID( $piID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM payroll_item_tax pit
                                   LEFT JOIN tax_group tg ON ( tg.tgID = pit.tgID )
                                   WHERE pit.piID = "' . (int)$piID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBypiIDs( $piIDs ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM payroll_item_tax 
                                   WHERE piID IN (' . addslashes( $piIDs ) . ')',
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