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
    * @return bool
    */
    public function isFound( $userID ) {
        return $this->UserSetting->isFound( $userID );
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
    public function save( $post ) {
        if( isset( $post['userID'] ) && isset( $post['language'] ) ) {
            if( $post['language'] == '' ) {
                $post['language'] = 'en_us';
            }
            else {
                $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
                $langList = $i18n->getLanguages( );

                if( isset( $langList[$post['language']] ) ) {
                    $post['language'] = $langList[$post['language']];
                }
            }

            $info = array( );
            $info['lang'] = $post['language'];

            if( $this->isFound( $post['userID'] ) ) {
                $this->UserSetting->update( 'user_setting', $info, 'WHERE userID = "' . (int)$post['userID'] . '"' );

                $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
                $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

                if( $userInfo['userID'] == $post['userID'] ) {
                    $time = mktime( 0, 0, 0, 1, 1, 1970 );
                    $this->Registry->setCookie( 'lang', $post['language'], $time );
                }
            }
            else {
                $info['userID'] = (int)$post['userID'];
                $this->UserSetting->insert( 'user_setting', $info );
            }
        }
    }
}
?>