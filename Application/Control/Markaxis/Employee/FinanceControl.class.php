<?php
namespace Markaxis\Employee;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: FinanceControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FinanceControl {


    // Properties


    /**
     * FinanceControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str

    public function view( ) {
        File::import( VIEW . 'Markaxis/Employee/EmployeeView.class.php' );
        $EmployeeView = new EmployeeView( );
        echo $EmployeeView->renderEdit( );
    } */


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        File::import( VIEW . 'Markaxis/Employee/FinanceView.class.php' );
        $FinanceView = new FinanceView( );
        Control::setOutputArrayAppend( array( 'form' => $FinanceView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        File::import( VIEW . 'Markaxis/Employee/FinanceView.class.php' );
        $FinanceView = new FinanceView( );
        Control::setOutputArrayAppend( array( 'form' => $FinanceView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function save( ) {
        File::import( MODEL . 'Markaxis/Employee/FinanceModel.class.php' );
        $FinanceModel = FinanceModel::getInstance( );
        $FinanceModel->save( Control::getPostData( ) );
    }
}
?>