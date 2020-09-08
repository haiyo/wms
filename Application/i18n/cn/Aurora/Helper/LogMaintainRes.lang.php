<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: LogMaintainRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LogMaintainRes extends Resource {


    // Properties


    /**
    * LogMaintainRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_LOG_100']  = '100KB (Approx. 1300+ lines)';
        $this->contents['LANG_LOG_200']  = '200KB (Approx. 2600+ lines)';
        $this->contents['LANG_LOG_300']  = '300KB (Approx. 3900+ lines)';
        $this->contents['LANG_LOG_400']  = '400KB (Approx. 5200+ lines)';
        $this->contents['LANG_LOG_500']  = '500KB (Approx. 6500+ lines)';
        $this->contents['LANG_LOG_1024'] = '1MB (Approx. 13,000+ lines)';
        $this->contents['LANG_LOG_2048'] = '2MB (Approx. 26,000+ lines)';
	}
}
?>