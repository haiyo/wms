<?php
namespace Aurora\Chat;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: MessageControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MessageControl {


    // Properties
    protected $MessageModel;
    protected $MessageView;


    /**
    * MessageControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->MessageModel = MessageModel::getInstance( );
        $this->MessageView = new MessageView( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function send( ) {
        $post = Control::getPostData( );

        if( $this->MessageModel->save( $post ) ) {
            $vars['bool'] = 1;
            $vars['data'] = $post;
            $vars['html'] = $this->MessageView->renderMessage( $post );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>