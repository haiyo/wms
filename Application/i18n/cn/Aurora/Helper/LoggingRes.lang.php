<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: LoggingRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LoggingRes extends Resource {


    // Properties


    /**
    * LoggingRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_LOG_FILE'] = 'Log to Error Log File';
        $this->contents['LANG_LOG_SEND'] = 'Log and Send Email to Webmaster';
        $this->contents['LANG_PRINT_ERROR'] = 'Log and Print Error(s) to Screen';
	}
}
?>