<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: IP.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IP extends \DAO {


    // Properties


    /**
     * Bank Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Performs IP2C mapping IP to Country code and name
     * @return mixed
     */
    public function getCountry( $ip ) {
        $sql = $this->DB->select( 'SELECT country_code, country_name FROM ip2c
                                   WHERE ' . addslashes( $ip ) . '
                                   BETWEEN begin_ip_num AND end_ip_num',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>