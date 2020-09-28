<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ProcessControl {


    // Properties
    protected $ProcessView;


    /**
     * ProcessControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ProcessView = new ProcessView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        $data = Control::getOutputArray( );
        echo $this->ProcessView->renderProcessForm( $data );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reprocessPayroll( ) {
        $data = Control::getOutputArray( );
        $vars = array( );
        $vars['bool'] = 1;
        $vars['data'] = $data;
        $vars['summary'] = $this->ProcessView->renderProcessSummary( $data );
        echo json_encode( $vars );
        exit;
    }
}
?>