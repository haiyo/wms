<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxControl {


    // Properties


    /**
     * TaxControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $output = Control::getOutputArray( );

        $TaxView = new TaxView( );
        Control::setOutputArrayAppend( array( 'form' => $TaxView->renderSettings( $output ) ) );
    }
}
?>