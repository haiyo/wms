<?php
namespace Markaxis\Expense;
use \Aurora\Component\CountryModel;
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
     */
    public function getCurrency( ) {
        $post = Control::getRequest( )->request( POST );

        $vars = array( );
        $vars['bool'] = 0;

        if( isset( $post['cID'] ) ) {
            $CountryModel = CountryModel::getInstance( );
            $vars = array( );
            $vars['data'] = $CountryModel->getBycID( $post['cID'] );
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getExpense( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->ExpenseModel->getByeiID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getMaxAmount( ) {
        $post = Control::getRequest( )->request( POST );

        $vars = array( );

        if( isset( $post['eiID'] ) && $vars['text'] = $this->ExpenseModel->getMaxAmount( $post['eiID'] ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->ExpenseModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveExpenseType( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );
        $vars = array( );
        $vars['bool'] = 0;

        if( $vars['data'] = $this->ExpenseModel->saveExpenseType( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteExpense( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->ExpenseModel->deleteExpense( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['errMsg'] = $this->ExpenseModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>