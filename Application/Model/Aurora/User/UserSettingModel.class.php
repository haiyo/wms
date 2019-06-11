<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserSettingModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserSettingModel extends \Model {


    // Properties
    protected $UserSetting;


    /**
    * UserSettingModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->UserSetting = new UserSetting( );
    }


    /**
    * Load user to class
    * @return void
    */
    public function load( $userID ) {
        $this->info = $this->UserSetting->getByUserID( $userID );
    }


    /**
    * Save user setting
    * @return int
    */
    public function save( $userID, $field, $value ) {
        $info = array( );
        $info[$field] = $value;

        return $this->UserSetting->update( 'user_setting', $info, 'WHERE userID = "' . (int)$userID . '"' );
    }
}
?>