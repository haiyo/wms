<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: SupervisorControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SupervisorControl {


    // Properties
    private $SupervisorModel;


    /**
     * SupervisorControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->SupervisorModel = new SupervisorModel( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getHistory( ) {
        $data = Control::getOutputArray( );
        echo json_encode( $this->SupervisorModel->getHistory( $data['list'] ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function apply( ) {
        $post = Control::getPostData( );

        if( $post['laID'] ) {
            $post['hasSup'] = $this->SupervisorModel->save( $post );

            $vars['bool'] = 1;
            $vars['data'] = $post;
            echo json_encode( $vars );
            exit;
        }
        else {
            $LeaveApplyModel = LeaveApplyModel::getInstance( );

            $vars['bool'] = 0;
            $vars['errMsg'] = $LeaveApplyModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>