<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveBalanceModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveBalanceModel extends \Model {


    // Properties
    protected $LeaveBalance;


    /**
     * LeaveBalanceModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->LeaveBalance = new LeaveBalance( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByltIDUserID( $ltID, $userID ) {
        return $this->LeaveBalance->getByltIDUserID( $ltID, $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getList( $q='' ) {
        return $this->Employee->getList( $q );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getTypeListByUserID( $userID ) {
        return $this->info = $this->LeaveBalance->getTypeListByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getSidebar( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $this->info = $this->LeaveBalance->getSidebarByUserID( $userInfo['userID'] );
        return $this->info;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Employee->setLimit( $post['start'], $post['length'] );

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'e.idnumber';
                    break;
                case 2:
                    $order = 'name';
                    break;
                case 3:
                    $order = 'd.title';
                    break;
                case 4:
                    $order = 'e.email1';
                    break;
                case 5:
                    $order = 'u.mobile';
                    break;
                case 6:
                    $order = 'u.suspended';
                    break;
            }
        }
        $results = $this->Employee->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }
}
?>