<?php
namespace Markaxis\Company;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: DepartmentManagerControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentManagerControl {


    // Properties
    private $DepartmentManagerModel;


    /**
     * DepartmentManagerControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->DepartmentManagerModel = DepartmentManagerModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getSuggestToken( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->DepartmentManagerModel->getSuggestToken( $data[1] );
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
        $data = Control::getOutputArray( );

        if( isset( $data['list']) ) {
            echo json_encode( $this->DepartmentManagerModel->getDepartmentResults( $data['list'] ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveDepartment( ) {
        $post = Control::getPostData( );

        if( isset( $post['managers'] ) && $post['managers'] ) {
            if( $this->DepartmentManagerModel->isValid( $post ) ) {
                $this->DepartmentManagerModel->save( );
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->DepartmentManagerModel->getErrMsg( );
                echo json_encode( $vars );
                exit;
            }
        }
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteDepartment( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['delete'] ) && $data['delete'] ) {
            $dID = Control::getRequest( )->request( POST, 'data' );
            $this->DepartmentManagerModel->delete( $dID );
        }

        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>