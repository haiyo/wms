<?php
namespace Aurora\Chat;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RoomControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RoomControl {


    // Properties
    protected $RoomModel;


    /**
    * RoomControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->RoomModel = RoomModel::getInstance( );
    }


    /**
     * DashboardControl Main
     * @return void
     */
    public function send( ) {
        $post = Control::getRequest( )->request( POST );
        $post = array_merge( $post, $this->RoomModel->create( $post ) );
        Control::setPostData( $post );


/*
        $info['notifyUserIDs'] = array( 34 );
        $info['notifyEvent'] = 'chatMessage';
        $info['notifyType'] = 'normal';
        $info['notifyMessage'] = $post['message'];
        $vars['data'] = $info;
        echo json_encode( $vars );
        exit;*/
    }
}
?>