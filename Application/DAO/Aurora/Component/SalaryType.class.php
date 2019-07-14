<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: SalaryType.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SalaryType extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $stID ) {
        $sql = $this->DB->select( 'SELECT COUNT(stID) FROM salary_type WHERE stID = "' . (int)$stID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM salary_type', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['stID']] = $row['type'];
            }
        }
        return $list;
    }
}
?>