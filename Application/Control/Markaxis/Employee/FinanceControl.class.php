<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: FinanceControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FinanceControl {


    // Properties
    protected $FinanceView;


    /**
     * FinanceControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->FinanceView = new FinanceView( );
    }


    /**
     * Render main navigation
     * @return string

    public function view( ) {
        $EmployeeView = new EmployeeView( );
        echo $EmployeeView->renderEdit( );
    } */


    /**
     * Render main navigation
     * @return string
     */
    public function add( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->FinanceView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;
        Control::setOutputArrayAppend( array( 'form' => $this->FinanceView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $FinanceModel = FinanceModel::getInstance( );
        $FinanceModel->save( Control::getPostData( ) );
    }
}
?>