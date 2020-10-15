<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserTaxModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserTaxModel extends \Model {


    // Properties
    protected $UserTax;



    /**
     * UserTaxModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->UserTax = new UserTax( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByPuID( $puID ) {
        return $this->UserTax->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        $success = array( );

        if( isset( $data['userTaxes'] ) && sizeof( $data['userTaxes'] ) ) {
            foreach( $data['userTaxes'] as $userTax ) {
                if( isset( $userTax['trID'] ) ) {
                    $info = array( );
                    $info['puID'] = $data['payrollUser']['puID'];
                    $info['trID'] = $userTax['trID'];
                    $info['title'] = $userTax['title'];
                    $info['amount'] = $userTax['amount'];
                    $info['remark'] = $userTax['remark'];
                    array_push($success, $this->UserTax->insert( 'payroll_user_tax', $info ) );
                }
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->UserTax->delete( 'payroll_user_tax',
                                    'WHERE putID NOT IN(' . implode(',', $success ) . ') AND 
                                           puID = "' . (int)$data['payrollUser']['puID'] . '"');
        }
        else {
            $this->deletePayroll( $data );
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['payrollUser']['puID'] ) ) {
            $this->UserTax->delete('payroll_user_tax','WHERE puID = "' . (int)$data['payrollUser']['puID'] . '"');
        }
    }
}
?>