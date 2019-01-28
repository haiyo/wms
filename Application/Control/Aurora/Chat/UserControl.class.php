<?php
namespace Aurora\Chat;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserControl {


    // Properties
    protected $UserModel;


    /**
    * UserControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->UserModel = UserModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function send( ) {
        $post = Control::getPostData( );

        if( $post['cuID'] = $this->UserModel->isValid( $post ) ) {
            Control::setPostData( $post );
        }
    }
}
?>