<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollContributionModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollContributionModel extends \Model {


    // Properties
    protected $PayrollContribution;


    /**
     * PayrollContributionModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->PayrollContribution = new PayrollContribution( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByPuID( $puID ) {
        return $this->PayrollContribution->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getChart( $date ) {
        return array( 'contributions' => $this->PayrollContribution->getChart( $date ) );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        $success = array( );

        if( isset( $data['puID'] ) && isset( $data['contribution'] ) && sizeof( $data['contribution'] ) ) {
            foreach( $data['contribution'] as $contribution ) {
                $info = array( );
                $info['puID'] = $data['puID'];
                $info['title'] = $contribution['title'];
                $info['trID'] = $contribution['trID'];
                $info['amount'] = $contribution['amount'];
                array_push($success, $this->PayrollContribution->insert( 'payroll_contribution', $info ) );
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->PayrollContribution->delete('payroll_contribution',
                                               'WHERE pcID NOT IN(' . implode(',', $success ) . ') AND 
                                                    puID = "' . (int)$data['puID'] . '"');
        }
        else {
            $this->deletePayroll( $data );
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['puID'] ) ) {
            $this->PayrollContribution->delete('payroll_contribution','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>