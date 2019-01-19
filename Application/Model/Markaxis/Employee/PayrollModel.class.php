<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: BankModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollModel extends \Model {


    // Properties
    protected $Payroll;



    /**
     * BankModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->info['pcID'] = '';
        $this->Payroll = new Payroll( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->Payroll->isFoundByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->Payroll->getByUserID( $userID, $column );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function loadInfo( $userID ) {
        return $this->info = $this->getByUserID( $userID, '*' );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['pcID'] ) && $data['pcID'] ) {
            $saveInfo = array( );
            $saveInfo['pcID'] = (int)$data['pcID'];

            if( $this->Payroll->isFoundByUserID( $data ) ) {
                $this->Payroll->update( 'employee_payroll', $saveInfo, 'WHERE userID = "' . (int)$data['userID'] . '"' );
            }
            else {
                $saveInfo['userID'] = (int)$data['userID'];
                $this->Payroll->insert( 'employee_payroll', $saveInfo );
            }
        }
    }
}
?>