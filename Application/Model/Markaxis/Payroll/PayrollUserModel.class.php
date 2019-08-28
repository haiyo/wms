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
        if( isset( $data['pID'] ) && isset( $data['empInfo']['userID'] ) ) {
            if( $payrollUserInfo = $this->getUserPayroll( $data['pID'], $data['empInfo']['userID'] ) ) {
                return $payrollUserInfo['puID'];
            }
            else {
                $info = array( );
                $info['pID'] = $data['pID'];
                $info['userID'] = $data['empInfo']['userID'];
                return $this->PayrollUser->insert('payroll_user', $info );
            }
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['pID'] ) && isset( $data['empInfo']['userID'] ) ) {
            if( $payrollUserInfo = $this->getUserPayroll( $data['pID'], $data['empInfo']['userID'] ) ) {
                $this->PayrollUser->delete('payroll_user', 'WHERE pID = "' . (int)$data['pID'] . '"' );
                return $payrollUserInfo['puID'];
            }
        }
    }
}
?>