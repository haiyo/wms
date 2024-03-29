<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Company.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Company extends \DAO {


    // Properties


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function loadInfo( ) {
        $sql = $this->DB->select( 'SELECT * FROM company', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getRegNumber( ) {
        $sql = $this->DB->select( 'SELECT regNumber FROM company', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql )['regNumber'];
        }
        return false;
    }
}
?>