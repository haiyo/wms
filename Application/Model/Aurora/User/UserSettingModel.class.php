<?php
namespace Aurora\User;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserSettingModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserSettingModel extends \Model {


    // Properties


    /**
    * UserSettingModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

	}


    /**
    * Load user to class
    * @return void
    */
    public function load( $userID ) {
        File::import( DAO . 'Aurora/User/UserSetting.class.php' );
        $UserSetting = new UserSetting( );
        $this->info = $UserSetting->getByUserID( $userID );
    }


    /**
    * Save user setting
    * @return int
    */
    public function save( $userID, $field, $value ) {
        $info = array( );
        $info[$field] = $value;

        File::import( DAO . 'Aurora/User/UserSetting.class.php' );
        $UserSetting = new UserSetting( );
        return $UserSetting->update( 'user_setting', $info, 'WHERE userID = "' . (int)$userID . '"' );
    }
}
?>