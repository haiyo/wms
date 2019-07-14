<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxGroup.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGroup extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $tgID ) {
        $sql = $this->DB->select( 'SELECT COUNT(tgID) FROM tax_group WHERE tgID = "' . (int)$tgID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getList( $selectable ) {
        $selectable = $selectable ? ' WHERE selectable = "1"' : '';

        $sql = $this->DB->select( 'SELECT tgID, title FROM tax_group' . $selectable,
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['tgID']] = $row['title'];
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getSelectList( ) {
        $sql = $this->DB->select( 'SELECT *, tgID AS id, title AS text FROM tax_group',
                                   __FILE__, __LINE__ );

        $list = array( );
        $list[] = array( 'tgID' => 0, 'parent' => 0, 'id' => 0, 'text' => 'None' );

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
    public function getAll( ) {
        $sql = $this->DB->select( 'SELECT *, tgID AS id, title AS text FROM tax_group',
                                    __FILE__, __LINE__ );

        $list = array( );
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
    public function getBytgID( $tgID ) {
        $sql = $this->DB->select( 'SELECT *, tgID AS id, title AS text FROM tax_group
                                   WHERE tgID = "' . (int)$tgID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>