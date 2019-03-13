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
     * @return str
     */
    public function overview( ) {
        $this->PayrollView->printAll( $this->PayrollView->renderOverview( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function slips( ) {
        $this->PayrollView->printAll( $this->PayrollView->renderSlips( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getProcessPass( ) {
        $vars = array( );
        $post = Control::getRequest( )->request( POST );

        if( $this->PayrollModel->allowProcessPass( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->PayrollModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function process( $args ) {
        if( isset( $args[1] ) ) {
            $this->PayrollView->printAll( $this->PayrollView->renderProcess( $args[1] ) );
        }
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