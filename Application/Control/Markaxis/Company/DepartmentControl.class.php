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
    public function getDepartmentResults( ) {
        $post = Control::getRequest( )->request( POST );

        echo json_encode( $this->DepartmentModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->DepartmentModel->isValid( $post ) ) {
            $post['userID'] = $UserModel->save( );
            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->DepartmentModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>