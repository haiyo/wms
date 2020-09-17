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
     * Return total count of records
     * @return int
     */
    public function isFound( $piID ) {
        $sql = $this->DB->select( 'SELECT COUNT(piID) FROM payroll_item 
                                   WHERE piID = "' . (int)$piID . '" AND deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT piID AS id, title, additional FROM payroll_item
                                   WHERE deleted <> "1"
                                   ORDER BY title', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['id']] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBypiID( $piID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_item
                                   WHERE piID = "' . (int)$piID . '" AND deleted <> "1"',
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
    public function getProcessList( ) {
        $sql = $this->DB->select( 'SELECT piID, title, ordinary, deduction, additional
                                   FROM payroll_item
                                   WHERE deleted <> "1"
                                   ORDER BY title', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getBasic( ) {
        $sql = $this->DB->select( 'SELECT pi.piID, pi.title, pi.formula, pi.basic
                                   FROM payroll_item pi 
                                   WHERE pi.basic = "1" AND 
                                         pi.deleted <> "1"',
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
    public function getOrdinary( ) {
        $sql = $this->DB->select( 'SELECT pi.piID, pi.title, pi.formula, pi.ordinary 
                                   FROM payroll_item pi 
                                   WHERE pi.ordinary = "1" AND 
                                         pi.deleted <> "1"',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['piID']] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getDeduction( ) {
        $sql = $this->DB->select( 'SELECT pi.piID, pi.title, pi.formula, pi.deduction 
                                   FROM payroll_item pi 
                                   WHERE pi.deduction = "1" AND 
                                         pi.deleted <> "1"',
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
    public function getDeductionAW( ) {
        $sql = $this->DB->select( 'SELECT pi.piID, pi.title, pi.formula, pi.deduction, pi.deductionAW
                                   FROM payroll_item pi 
                                   WHERE pi.deductionAW = "1" AND 
                                         pi.deleted <> "1"',
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
    public function getAdditional( ) {
        $sql = $this->DB->select( 'SELECT pi.piID, pi.title, pi.formula, pi.additional
                                   FROM payroll_item pi 
                                   WHERE pi.additional = "1" AND 
                                         pi.deleted <> "1"',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['piID']] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q, $order='pi.title DESC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND pi.title LIKE "%' . $q . '%"' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS * FROM payroll_item pi
                                   WHERE pi.deleted <> "1" ' . $q . '
                                   ORDER BY ' . $order . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        $sql = $this->DB->select( 'SELECT FOUND_ROWS()', __FILE__, __LINE__ );
        $row = $this->DB->fetch( $sql );
        $list['recordsTotal'] = $row['FOUND_ROWS()'];
        return $list;
    }
}
?>