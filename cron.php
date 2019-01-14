<?php
require __DIR__ . '/config.ini.php';

require_once( APP . 'Application.class.php' );
$Application = new Application( );
$Application->initCron( $argv );
?>