<?php
namespace Aurora\User;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserSettingControl {


    // Properties
    private $UserSettingModel;


    /**
     * UserControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->UserSettingModel = new UserSettingModel( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveProfile( ) {
        $this->saveUser( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveUser( ) {
        $post = Control::getPostData( );

        $this->UserSettingModel->save( $post );
    }
}
?>