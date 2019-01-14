<?php
namespace Aurora\Component;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: AuditLogModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AuditLogModel extends \Model {


    // Properties


    /**
     * AuditLogModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        File::import( DAO . 'Aurora/Component/AuditLog.class.php' );
        $AuditLog = new AuditLog( );
        $AuditLog->getList( );
    }


    /**
     * Create an attachment entry
     * @return int
     */
    public function view( ) {
        //
    }


    /**
     * Create an attachment entry
     * @return int
     */
    public function log( $data ) {
        File::import( DAO . 'Aurora/Component/AuditLog.class.php' );
        $AuditLog = new AuditLog( );
        $AuditLog->insert( 'audit_log', $data );
    }
}
?>