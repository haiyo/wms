<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PerformRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PerformRes extends Resource {


    /**
    * PerformRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Performance Configurations';
        $this->contents['LANG_ENABLE_GZIP'] = 'Enable Gzip Compression';
        $this->contents['LANG_ENABLE_GZIP_DESC'] = 'Reduce bandwidth usage by compressing all web page output
              using the Gzip compressor.';
        $this->contents['LANG_ENABLE_AURORA_CACHE'] = 'Enable Aurora Caching';
        $this->contents['LANG_ENABLE_AURORA_CACHE_DESC'] = 'Aurora can perform content and application code level caching from
              pages which are not updated frequently to help reduce system resources and accelerate requests.';
        $this->contents['LANG_APP_EXCEPTION_LOG'] = 'Application Exception Logging';
        $this->contents['LANG_APP_EXCEPTION_LOG_DESC'] = 'Select the type of action(s) Aurora should perform whenever
              <strong>non-critical</strong> exception errors occur. Crtical errors will be log and
              email to Webmaster regardless of this setting.';
        $this->contents['LANG_LOG_MAINTAIN'] = 'Log File Maintenance';
        $this->contents['LANG_LOG_MAINTAIN_DESC'] = 'Log file may take up considerable amount of disk space after some time.
              Select a size restriction for the log file and Aurora will perform purging of the logs automatically.';
        $this->contents['LANG_ENABLE_AUDIT'] = 'Enable Audit Trail Recording';
        $this->contents['LANG_ENABLE_AUDIT_DESC'] = 'Performs audit trail recording for all user\'s action and
              communications. Audit records can be retrieve for viewing at System Control /
              System Maintenance.';
        $this->contents['LANG_AUDIT_MAINTAIN'] = 'Audit Trail Maintenance';
        $this->contents['LANG_AUDIT_MAINTAIN_DESC'] = 'Trails are recorded in the database in order to easily mapped records
              to each individual user\'s account. It may take up considerable amount of disk space after some
              time. Select a criteria for Aurora to purge old records from the database.';
	}
}
?>