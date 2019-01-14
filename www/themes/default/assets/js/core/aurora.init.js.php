<?php
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: JSInit.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
$JSInit = new JSInit( );
$JSInit->init( );

class JSInit {


    // Properties


    /**
    * JSInit Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * JSInit Main
    * @return void
    */
    public function init( ) {
        header( 'Content-Type: text/javascript; charset=UTF-8' );
        echo 'var Aurora = {';

        if( sizeof( $_GET ) > 0 ) {
            $_GET['CSRF_TOKEN'] = isset( $_COOKIE['csrfToken'] ) ? $_COOKIE['csrfToken'] : '';
            foreach( $_GET as $key => $value ) {
                echo $key . ': "' . urldecode( $value ) . '",';
            }
            echo '};';
        }
        echo 'Aurora.i18n = {};';
        exit;
    }
}
?>