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
     * Get File Information
     * @return mixed
     */
    public function getTaxGroupListByOffice( $args ) {
        // userID && oID
        if( isset( $args[1] ) && is_numeric( $args[1] ) && isset( $args[2] ) && is_numeric( $args[2] ) ) {
            $vars['html'] = $this->FinanceView->renderTaxGroupList( $args[1], $args[2] );
            $vars['bool'] = 1;
            echo json_encode($vars);
            exit;
        }
    }


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
    public function saveUser( ) {
        $FinanceModel = FinanceModel::getInstance( );
        $FinanceModel->save( Control::getPostData( ) );
    }
}
?>