<?php
namespace Markaxis\TaxFile;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: IRA8AControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IRA8AControl {


    // Properties
    private $IRA8AModel;
    private $IRA8AView;


    /**
     * IR8AControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->IRA8AModel = IRA8AModel::getInstance( );
        $this->IRA8AView = new IRA8AView( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function prepareUserDeclaration( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArrayAppend( array( 'ira8a' => $this->IRA8AModel->prepareUserDeclaration( $data ) ) );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function saveIr8a( ) {
        $data = Control::getOutputArray( );
        $this->IRA8AModel->prepareUserDeclaration( $data );

        $vars = array( );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return void
     */
    public function saveIra8a( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
        $vars = array( );

        if( $vars['data'] = $this->IRA8AModel->saveIra8a( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->IRA8AModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function downloadA8A( $args ) {
        // tfID
        if( isset( $args[1] ) ) {
            echo $this->IRA8AView->renderXML( $args[1] );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewIr8a( $args ) {
        //userID && year
        if( Control::hasPermission('Markaxis', 'process_payroll' ) &&
            isset( $args[1] ) && isset( $args[2] ) ) {
            $this->IRA8AView->renderIr8a( $args[1], $args[2] );
            exit;
        }
    }
}
?>