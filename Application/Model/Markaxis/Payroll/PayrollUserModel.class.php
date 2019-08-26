<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollUserModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollUserModel extends \Model {


    // Properties
    protected $PayrollUser;



    /**
     * PayrollUserModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->PayrollUser = new PayrollUser( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getUserPayroll( $pID, $userID ) {
        return $this->PayrollUser->getUserPayroll( $pID, $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        if( isset( $data['pID'] ) ) {
            $info = array( );
            $info['pID'] = $data['pID'];
            $info['userID'] = $data['empInfo']['userID'];
            $info['gross'] = $data['summary']['gross'];
            $info['deduction'] = $data['summary']['deduction'];
            $info['net'] = $data['summary']['net'];
            $info['claim'] = $data['summary']['claim'];
            $info['fwl'] = $data['summary']['fwl'];
            $info['sdl'] = $data['summary']['sdl'];
            $info['levy'] = $data['summary']['levy'];
            $info['contribution'] = $data['summary']['contribution'];

            if( $payrollUserInfo = $this->getUserPayroll( $data['pID'], $data['empInfo']['userID'] ) ) {
                $this->PayrollUser->update( 'payroll_user', $info, 'WHERE puID = "' . (int)$payrollUserInfo['puID'] . '"' );
                return $payrollUserInfo['puID'];
            }
            else {
                return $this->PayrollUser->insert( 'payroll_user', $info );
            }
        }
    }
}
?>