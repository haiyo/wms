<?php
namespace Markaxis\Expense;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ExpenseControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseControl {


    // Properties
    protected $ExpenseModel;
    protected $ExpenseView;


    /**
     * ExpenseControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ExpenseModel = ExpenseModel::getInstance( );
        $this->ExpenseView = new ExpenseView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->ExpenseView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getExpensesResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->ExpenseModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string

    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
        $this->ExpenseModel->savePayroll( $data, $post );
    } */
}
?>