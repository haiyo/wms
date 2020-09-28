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
        $sql = $this->DB->select( 'SELECT COUNT(tgID) FROM tax_group 
                                   WHERE tgID = "' . (int)$tgID . '" AND deleted = "0"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getByUserID( $userID, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ', tg.title, tg.summary
                                   FROM employee_tax et
                                   LEFT JOIN tax_group tg ON ( tg.tgID = et.tgID )
                                   WHERE userID = "' . (int)$userID . '" AND
                                         tg.deleted = "0"',
                                   __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list['mainGroup'][$row['tgID']] = $row;

                $sql2 = $this->DB->select( 'SELECT tgID, title, parent, summary
                                            FROM ( SELECT * FROM tax_group WHERE deleted = "0" ORDER BY parent, tgID) tax_group,
                                            ( SELECT @pv := "' . (int)$row['tgID'] . '" ) initialisation
                                              WHERE find_in_set( parent, @pv ) > 0 AND @pv := concat( @pv, ",", tgID )',
                                            __FILE__, __LINE__ );

                if( $this->DB->numrows( $sql2 ) > 0 ) {
                    while( $child = $this->DB->fetch( $sql2 ) ) {
                        $list['mainGroup'][$row['tgID']]['child'][] = $child;
                    }
                }
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getList( $selectable ) {
        $selectable = $selectable ? ' AND selectable = "1"' : '';

        $sql = $this->DB->select( 'SELECT tgID, title FROM tax_group
                                   WHERE deleted = "0"' . $selectable,
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
    public function getListByOfficeID( $oID ) {
        $sql = $this->DB->select( 'SELECT tgID, title FROM tax_group 
                                   WHERE officeID = "' . (int)$oID . '" AND
                                         selectable = "1" AND
                                         deleted = "0"',
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
        $sql = $this->DB->select( 'SELECT *, tgID AS id, title AS text FROM tax_group
                                   WHERE deleted = "0"',
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
        $sql = $this->DB->select( 'SELECT *, tgID AS id, title AS text FROM tax_group 
                                   WHERE deleted = "0"',
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
                                   WHERE tgID = "' . (int)$tgID . '" AND deleted = "0"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByParentTgID( $parentTgID ) {
        $sql = $this->DB->select( 'SELECT tgID FROM tax_group
                                   WHERE parent = "' . (int)$parentTgID . '" AND
                                         deleted = "0"',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>