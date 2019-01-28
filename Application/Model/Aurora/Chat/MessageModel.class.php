<?php
namespace Aurora\Chat;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: MessageModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MessageModel extends \Model {


    // Properties
    protected $Message;


    /**
     * MessageModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $this->Message = new Message( );
    }


    /**
     * Add new user
     * @return int
     */
    public function save( $data ) {
        if( isset( $data['cuID'] ) && isset( $data['message'] ) ) {
            $info = array( );
            $info['cuID'] = (int)$data['cuID'];
            $info['message'] = $data['message'];
            $info['created'] = date( 'Y-m-d H:i:s' );
            return $this->Message->insert( 'chat_message', $info );
        }
    }
}
?>