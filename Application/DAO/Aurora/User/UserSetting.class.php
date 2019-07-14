<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserSetting.class.php, v 2.0 Exp $
 * @desc User Settings Management
*/

class UserSetting extends \DAO {


    // Properties


    /**
    * Return user settings
    * @return mixed
    */
    public function getByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT * FROM user_setting
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>