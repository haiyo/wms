<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollUserTaxModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollUserTaxModel extends \Model {


    // Properties
    protected $PayrollUserTax;



    /**
     * PayrollUserTaxModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->PayrollUserTax = new PayrollUserTax( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByPuID( $puID ) {
        return $this->PayrollUserTax->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        $success = array( );

        if( isset( $data['items'] ) && sizeof( $data['items'] ) ) {
            foreach( $data['items'] as $item ) {
                $info = array( );
                $info['puID'] = $data['puID'];
                $info['trID'] = $item['trID'];
                $info['amount'] = $item['amount'];
                $info['remark'] = $item['remark'];
                array_push($success, $this->PayrollUserTax->insert( 'payroll_user_tax', $info ) );
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->PayrollUserTax->delete('payroll_user_tax',
                                           'WHERE puiID NOT IN(' . implode(',', $success ) . ') AND 
                                                        puID = "' . (int)$data['puID'] . '"');
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
        if( isset( $data['puID'] ) ) {
            $this->PayrollUserTax->delete('payroll_user_tax','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>