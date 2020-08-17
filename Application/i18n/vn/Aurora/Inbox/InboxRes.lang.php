<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: InboxRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class InboxRes extends Resource {


    /**
    * InboxRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_MESSAGES'] = 'Messages';
        $this->contents['LANG_VIEW_ALL'] = 'View All';
        $this->contents['LANG_TITLE'] = 'Message Inbox';
        $this->contents['LANG_INBOX'] = 'Inbox';
        $this->contents['LANG_TO_ME'] = 'to me';
        $this->contents['LANG_TO'] = 'To';
        $this->contents['LANG_SUBJECT'] = 'Subject';
        $this->contents['LANG_NO_SUBJECT'] = 'no subject';
        $this->contents['LANG_DRAFT'] = 'Draft';
        $this->contents['LANG_NO_MAILS'] = 'You have no mails at the moment.';
        $this->contents['LANG_NEW_MESSAGE'] = 'Compose New Message';
        $this->contents['LANG_EDIT_DRAFT'] = 'Edit Draft';
        $this->contents['LANG_SHOW_QUOTED_MESSAGE'] = 'Show Quoted Message';
        $this->contents['LANG_HIDE_QUOTED_MESSAGE'] = 'Hide Quoted Message';
        $this->contents['LANG_RE'] = 'Re:';
        $this->contents['LANG_DISCARD'] = 'Discard';
        $this->contents['LANG_SAVE_AS_DRAFT'] = 'Save as Draft';
        $this->contents['LANG_SEND_MESSAGE'] = 'Send Message';
        $this->contents['LANG_INVALID_MESSAGE'] = 'Invalid Message';
        $this->contents['LANG_NO_CONTENT'] = 'There is no content to send. You should provide at least a subject, text body or attachment.';
        $this->contents['LANG_SEND_NO_SUBJECT'] = 'Send this message without subject?';
        $this->contents['LANG_SEND_NO_CONTENT'] = 'Send this message without body text?';
        $this->contents['LANG_NO_MESSAGE'] = 'You must provide at least body text or attachment.';
        $this->contents['LANG_NO_RECIPIENT'] = 'You must provide at least one recipient.';
        $this->contents['LANG_CONFIRM_LEAVE'] = 'Once you leave this conversation, you will not receive further replies / notifications. Proceed?';
        $this->contents['LANG_REMOVE'] = 'Remove';
        $this->contents['LANG_ADDED'] = 'added';
        $this->contents['LANG_HAS_LEFT'] = 'has left the conversation';
        $this->contents['LANG_DELETE'] = 'You have not left this conversation. You will still receive notification if someone reply to the message. Proceed?';
        $this->contents['LANG_DELETED_ITEMS'] = 'Trash Items';
        $this->contents['LANG_MARK_AS_STARRED'] = 'Mark as Starred';
        $this->contents['LANG_MARK_AS_UNSTARRED'] = 'Mark as Unstarred';
        $this->contents['LANG_SHOW_CC'] = 'Show Cc/Bcc';
        $this->contents['LANG_HIDE_CC'] = 'Hide Cc/Bcc';
	}
}
?>