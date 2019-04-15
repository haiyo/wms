<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ChildCareControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChildCareControl {


    // Properties


    /**
     * ChildCareControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function addType( ) {
        $output = Control::getOutputArray( );

        $ChildCareView = new ChildCareView( );
        Control::setOutputArrayAppend( array( 'form' => $ChildCareView->renderAddType( ) ) );
    }
}
?>