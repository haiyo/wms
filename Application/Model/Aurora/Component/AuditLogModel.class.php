<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: AuditLogModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AuditLogModel extends \Model {


    // Properties
    protected $AuditLog;


    /**
     * AuditLogModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->AuditLog = new AuditLog( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        $this->AuditLog->getList( );
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
        $this->AuditLog->insert( 'audit_log', $data );
    }
}
?>