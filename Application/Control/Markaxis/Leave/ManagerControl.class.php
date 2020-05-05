<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ManagerControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagerControl {


    // Properties
    private $ManagerModel;


    /**
     * ManagerControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ManagerModel = ManagerModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getHistory( ) {
        $data = Control::getOutputArray( );
        echo json_encode( $this->ManagerModel->getHistory( $data['list'] ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function setLeaveAction( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

        if( $this->ManagerModel->setLeaveAction( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function apply( ) {
        $post = Control::getPostData( );

        if( isset( $post['laID'] ) && $post['laID'] ) {
            $post['hasSup'] = $this->ManagerModel->save( $post );
            $vars['bool'] = 1;
            $vars['data'] = $post;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>