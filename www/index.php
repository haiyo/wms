<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: index.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

if( $_SERVER['HTTP_HOST'] != 'localhost' ) {
    $subdomain = strip_tags( trim( preg_replace( '/.hrmscloud.net.*$/', '', $_SERVER['HTTP_HOST'] ) ) );

    if( is_readable('../../' . $subdomain . '/config.ini.php') ) {
        require_once( '../../' . $subdomain . '/config.ini.php' );
    }
    else {
        header( 'location: https://www.hrmscloud.net/404.html' );
    }
}

require_once( '../config.ini.php' );
require_once( APP . 'Application.class.php' );
$Application = new Application( );
$Application->init( );