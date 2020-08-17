<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LoginRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LoginRes extends Resource {

    
    /**
    * LoginRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_LANGUAGE'] = 'Language';
        $this->contents['LANG_LOGIN_TITLE'] = 'Sign in to {WEBSITE_NAME}';
        $this->contents['LANG_LOGIN_DESCRIPT'] = 'You need authorization to access this area.';
        $this->contents['LANG_EMAIL_ADDRESS'] = 'Email Address';
        $this->contents['LANG_SIGN_IN'] = 'Sign In';
        $this->contents['LANG_FORGOT_PASSWORD'] = 'Forgot Password?';
        $this->contents['LANG_PASSWORD'] = 'Password';
        $this->contents['LANG_ENTER_VALID_EMAIL'] = 'Please enter a valid email address.';
        $this->contents['LANG_ENTER_VALID_USERNAME'] = 'Please enter a valid username.';
        $this->contents['LANG_ENTER_PASSWORD'] = 'Please enter your password.';
        $this->contents['LANG_ENTER_ALL_FIELDS'] = 'Please enter all fields.';
        $this->contents['LANG_PLEASE_ENTER_EMAIL'] = 'Please enter email address.';
        $this->contents['LANG_LOGIN_ERROR'] = 'Invalid Login';
        $this->contents['LANG_INVALID_LOGIN'] = 'Incorrect Username or Password Combination. Password is case sensitive. Please check your CAPS lock key.';
        $this->contents['LANG_OOPS'] = 'Oops...';
        $this->contents['LANG_SERVICE_UNAVAILABLE'] = 'The login service is currently unavailable. You may have exceeded the maximum number of login attempt. Please try again later.';
	}
}
?>