<?php

/**
 * @author Andy L.W.L <andylam@hwzcorp.com>
 * @since Saturday, February 19, 2005
 * @version $Id: Main.class.php, v 1.0 Exp $
 */

class ImageVerification
{


    var $DB;
    var $length;


    /**
    * Application Constructor
    * The main core application settings & classes will be register here.
    * Performs connection to database & passing important instances to the
    * registry.
    * @returns void
    */
    function __construct( $length=6 )
    {                     
        $Registry = Registry::open( );
        $this->DB = $Registry->get( HKEY_CLASS, 'DB' );
        
        $this->length = (int)$length;
        
        // garbage collect from database
        // remove records older than 30 minutes.
        /* $this->DB->delete( 'DELETE FROM botcode WHERE ( expire + INTERVAL 1800 SECOND ) < NOW( )',
                            __FILE__, __LINE__ ); */
    }
    

    /**
    * Generates an id/code pair
    * The id is not the "code" which actually appears in the image. They are different.
    * So we can call the image genrating script with the id number and it will look up
    * the code to actually print into the image.
    *
    * @access public
    * @return int
    */
    function randomID( )
    {
    	// returns string
        $chars = '23456789';

        // generate code which is to appear in image
        $code = '';
        while( strlen( $code ) < $this->length )
        {
        	$code .= substr( $chars, mt_rand( )% ( strlen( $chars ) ), 1 );
        }
        
        // generate 32 char random id
        $token = MD5( uniqid( mt_rand( ) ) );

        // insert record into database
        $SQl = array( );
        $SQL['token']  = $token;
        $SQL['code']   = $code;
        $SQL['expire'] = date( 'Y-m-d H:i:s' );

        $this->DB->insert( 'INSERT INTO botcode SET ' . $this->DB->compose( $SQL ),
                                   __FILE__, __LINE__ );

        return $token;
    }

    
    /**
    * Generates an id/code pair
    * The id is not the "code" which actually appears in the image. They are different.
    * So we can call the image genrating script with the id number and it will look up
    * the code to actually print into the image.
    *
    * @access public
    * @return int
    */
    function verified( $token, $code )
    {
    	$sql = $this->DB->select( 'SELECT botID FROM botcode
                                   WHERE token = "' . addslashes( $token ) . '" AND
                                         code  = "' . (int)$code . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 )
        {
            $row = $this->DB->fetch( $sql );
            
            // Has been verified, we don't need it anymore.
            $this->DB->delete( 'DELETE FROM botcode WHERE botID = "' . (int)$row['botID'] . '"',
                                __FILE__, __LINE__ );
            
            return true;
        }
        
        return false;
    }
}
?>