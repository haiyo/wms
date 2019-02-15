<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Payroll.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Payroll extends \DAO {


    // Properties


    /**
     * Payroll Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $prID ) {
        $sql = $this->DB->select( 'SELECT COUNT(prID) FROM payroll WHERE prID = "' . (int)$prID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getPayruns( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS * FROM payrun pr',
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


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByRange( $startDate, $endDate ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT *, MONTH(startDate) AS startIndex FROM payroll p WHERE startDate 
                                   BETWEEN "' . addslashes( $startDate ) . '" AND "' . addslashes( $endDate ) . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['startIndex']] = $row;
            }
        }
        return $list;
    }
}
?>