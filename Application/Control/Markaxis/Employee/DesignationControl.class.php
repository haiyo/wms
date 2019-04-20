<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: DesignationControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationControl {


    // Properties
    private $DesignationModel;


    /**
     * DesignationControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->DesignationModel = DesignationModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $DesignationView = new DesignationView( );
        Control::setOutputArrayAppend( array( 'form' => $DesignationView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getDesignationResults( ) {
        $post = Control::getRequest( )->request( POST );

        echo json_encode( $this->DesignationModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->DesignationModel->isValid( $post ) ) {
            $post['userID'] = $this->DesignationModel->save( );
            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->DesignationModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>