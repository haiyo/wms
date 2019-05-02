<?php
namespace Markaxis\Company;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: DepartmentControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentControl {


    // Properties
    private $DepartmentModel;


    /**
     * DepartmentControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->DepartmentModel = DepartmentModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $DepartmentView = new DepartmentView( );
        Control::setOutputArrayAppend( array( 'form' => $DepartmentView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCountList( $data ) {
        if( isset( $data[1] ) && $data[1] == 'department' && isset( $data[2] ) ) {
            Control::setOutputArrayAppend( array( 'list' => $this->DepartmentModel->getCountList( $data[2] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getDepartmentResults( ) {
        $post = Control::getRequest( )->request( POST );

        echo json_encode( $this->DepartmentModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveDepartment( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->DepartmentModel->isValid( $post ) ) {
            $post['dID'] = $this->DepartmentModel->save( );
            Control::setPostData( $post );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteDepartment( ) {
        $oID = Control::getRequest( )->request( POST, 'data' );

        $this->DepartmentModel->delete( $oID );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>