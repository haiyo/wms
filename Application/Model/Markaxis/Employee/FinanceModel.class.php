<?php
namespace Markaxis\Employee;
use \Library\IO\File;
use \Markaxis\Employee\PayrollModel as FinancePayrollModel;
use \Markaxis\Employee\TaxModel as FinanceTaxModel;
use \Markaxis\Employee\LeaveTypeModel as FinanceLeaveTypeModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: FinanceModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FinanceModel extends \Model {


    // Properties
    protected $Finance;



    /**
     * FinanceModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->Finance->isFoundByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->Finance->getByUserID( $userID, $column );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        File::import(MODEL . 'Markaxis/Employee/BankModel.class.php');
        $BankModel = new BankModel( );
        $BankModel->save( $data );

        File::import(MODEL . 'Markaxis/Employee/PayrollModel.class.php');
        $PayrollModel = new FinancePayrollModel( );
        $PayrollModel->save( $data );

        File::import(MODEL . 'Markaxis/Employee/TaxModel.class.php');
        $FinanceTaxModel = new FinanceTaxModel( );
        $FinanceTaxModel->save( $data );

        File::import(MODEL . 'Markaxis/Employee/LeaveTypeModel.class.php');
        $FinanceLeaveTypeModel = new FinanceLeaveTypeModel( );
        $FinanceLeaveTypeModel->save( $data );
    }
}
?>