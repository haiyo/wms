<?php
namespace Aurora;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ForgotPassword.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ForgotPassword extends DAO {


    // Properties

    
    /**
    * ForgotPassword Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function getByToken( $token ) {
        $sql = $this->DB->select( 'SELECT * FROM forgot_password
                                   WHERE token = "' . addslashes( $token ) . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>