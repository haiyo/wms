<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: Application.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

require '/Users/andylam/Sites/wms/config.ini.php';

require_once(APP . 'Application.class.php');
$Application = new Application( );
$Application->initCron( $argv );
?>