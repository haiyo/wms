<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollControl {


    // Properties


    /**
     * PayrollControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function overview( ) {
        File::import( VIEW . 'Markaxis/Payroll/PayrollView.class.php' );
        $PayrollView = new PayrollView( );
        $PayrollView->printAll( $PayrollView->renderOverview( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function process( ) {
        File::import( VIEW . 'Markaxis/Payroll/PayrollView.class.php' );
        $PayrollView = new PayrollView( );
        $PayrollView->printAll( $PayrollView->renderProcess( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function settings( ) {
        $output = Control::getOutputArray( );

        File::import( VIEW . 'Markaxis/Payroll/PayrollView.class.php' );
        $PayrollView = new PayrollView( );
        $PayrollView->printAll( $PayrollView->renderSettings( $output['form'] ) );
    }
}
?>