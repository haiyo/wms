<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: AdditionalControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdditionalControl {


    // Properties


    /**
     * AdditionalControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function view( ) {
        $EmployeeView = new EmployeeView( );
        echo $EmployeeView->renderEdit( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        $AdditionalView = new AdditionalView( );
        Control::setOutputArrayAppend( array( 'form' => $AdditionalView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        $AdditionalView = new AdditionalView( );
        Control::setOutputArrayAppend( array( 'form' => $AdditionalView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function save( ) {
        $AdditionalModel = AdditionalModel::getInstance( );
        $AdditionalModel->save( Control::getPostData( ) );
    }
}
?>