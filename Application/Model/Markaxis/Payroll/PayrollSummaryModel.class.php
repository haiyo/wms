<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollSummaryModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollSummaryModel extends \Model {


    // Properties
    protected $PayrollSummary;



    /**
     * PayrollSummaryModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->PayrollSummary = new PayrollSummary( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByPuID( $puID ) {
        return $this->PayrollSummary->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        if( isset( $data['puID'] ) ) {
            $info = array( );
            $info['puID'] = $data['puID'];
            $info['gross'] = $data['summary']['gross'];
            $info['deduction'] = $data['summary']['deduction'];
            $info['net'] = $data['summary']['net'];
            $info['claim'] = $data['summary']['claim'];

            if( $summaryInfo = $this->getByPuID( $data['puID'] ) ) {
                $this->PayrollSummary->update( 'payroll_summary', $info,
                                               'WHERE psID = "' . (int)$summaryInfo['psID'] . '"' );

                return $summaryInfo['psID'];
            }
            else {
                return $this->PayrollSummary->insert('payroll_summary', $info );
            }
        }
    }
}
?>