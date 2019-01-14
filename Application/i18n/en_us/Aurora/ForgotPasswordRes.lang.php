<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ForgotPasswordRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ForgotPasswordRes extends Resource {

    
    /**
    * ForgotPasswordRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_TOKEN_EXPIRED'] = 'The token has expired.';
        $this->contents['LANG_PASSWORD_CANNOT_EMPTY'] = 'Password cannot be empty.';
        $this->contents['LANG_RESET_PASSWORD'] = 'Reset Password';
        $this->contents['LANG_RESET_PASSWORD_DESCRIPTION'] = 'Your password should be difficult for others to guess.';
        $this->contents['LANG_NEW_PASSWORD'] = 'New Password';
        $this->contents['LANG_RE_ENTER_PASSWORD'] = 'Re-enter Password';
        $this->contents['LANG_PLEASE_ENTER_PASSWORD'] = 'Please enter a new Password';
        $this->contents['LANG_PLEASE_RE_ENTER_PASSWORD'] = 'Please ee-enter Password';
        $this->contents['LANG_PASSWORD_MISMATCH'] = 'Password Mismatch';
        $this->contents['LANG_PASSWORD_MISMATCH_DESCRIPTION'] = 'Your password and confirmation password do not match.';
        $this->contents['LANG_ERROR'] = 'Error';
        $this->contents['LANG_DONE'] = 'Done!';
        $this->contents['LANG_SENT'] = 'Sent!';
        $this->contents['LANG_GO_TO_LOGIN'] = 'Go to Login page now.';
        $this->contents['LANG_LINK_SEND_TO'] = 'A link to reset your password has been sent to: ';
        $this->contents['LANG_RESET_PASSWORD_EMAIL'] = 'There has been a request to reset your password for Markaxis HRMS. 
                                                        To reset your password use this link:<br /><br />
                                                        ' . ROOT_URL . 'admin/forgotPassword/token/{TOKEN}<br /><br />
                                                        If you did not make a request to reset your password please notify {MAIL_FROM}
                                                        by responding to this email.<br /><br />
                                                        Best regards<br />{MAIL_FROM}';
	}
}
?>