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
    private $DepartmentView;


    /**
     * DepartmentControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->DepartmentModel = DepartmentModel::getInstance( );
        $this->DepartmentView = new DepartmentView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_department' ) ) {
            Control::setOutputArrayAppend( $this->DepartmentView->renderSettings( ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getDepartment( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->DepartmentModel->getBydID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getDepartmentResults( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_department' ) ) {
            $post = Control::getRequest( )->request( POST );
            Control::setOutputArray( array( 'list' => $this->DepartmentModel->getResults( $post ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveDepartment( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_department' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

            if( $this->DepartmentModel->isValid( $post ) ) {
                $post['dID'] = $this->DepartmentModel->save( );
                Control::setPostData( $post );
            }
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteDepartment( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_department' ) ) {
            $dID = Control::getRequest( )->request( POST, 'data' );

            $this->DepartmentModel->delete( $dID );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>