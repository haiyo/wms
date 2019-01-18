<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollControl {


    // Properties
    protected $PayrollView;


    /**
     * PayrollControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollView = new PayrollView( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function overview( ) {
        $this->PayrollView->printAll( $this->PayrollView->renderOverview( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function process( ) {
        $this->PayrollView->printAll( $this->PayrollView->renderProcess( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function settings( ) {
        $output = Control::getOutputArray( );
        $this->PayrollView->printAll( $this->PayrollView->renderSettings( $output['form'] ) );
    }
}
?>