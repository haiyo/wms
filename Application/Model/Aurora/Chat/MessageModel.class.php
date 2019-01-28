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
            $this->info['cuID'] = (int)$data['cuID'];
            $this->info['message'] = $data['message'];
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            return $this->Message->insert( 'chat_message', $this->info );
        }
    }
}
?>