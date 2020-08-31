<?php
namespace Markaxis\Calendar;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EventRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EventRes extends Resource {


    /**
    * EventRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_DEFAULT_TITLE'] = 'Lịch sự kiện';
        $this->contents['LANG_CALENDAR_SETTINGS'] = 'Cài đặt lịch';
        $this->contents['LANG_RETRIEVE_EVENT_FROM'] = 'Lấy sự kiện từ';
        $this->contents['LANG_ADVANCED_DESCRIPT'] = 'If posting new events requires approval, all approving
                                                     officers including the Administrator will receive private
                                                     message and email notifications for new events posted.';
        $this->contents['LANG_NEW_EVENTS'] = 'Posting of New Events';
        $this->contents['LANG_APPROVING_OFFICERS'] = 'Approving Officer(s)';
        $this->contents['LANG_ADMIN_DEFAULT'] = 'Note: The Administrator is by default the approving officer.';
        $this->contents['LANG_UPCOMING_EVENT'] = 'Sự kiện sắp tới';
        $this->contents['LANG_NO_UPCOMING_EVENT'] = 'Không có sự kiện sắp diễn ra hôm nay';
        $this->contents['LANG_VIEW_CALENDAR'] = 'Xem lịch';
        $this->contents['LANG_EVENT_INFORMATION'] = 'Event Information';
        $this->contents['LANG_AGENDA'] = 'Agenda';
        $this->contents['LANG_AGENDA_LIST'] = 'Agenda List';
        $this->contents['LANG_EVENT_NO_RECORD'] = 'There is no event on this date.<br /><a href="" class="createSingle">Create event on this date.</a>';
        $this->contents['LANG_PROVIDE_ALL_REQUIRED'] = 'Please provide all required fields.';
        $this->contents['LANG_ALL_DAY'] = 'All day event';
        $this->contents['LANG_CREATE_NEW_EVENT'] = 'Create New Event';
        $this->contents['LANG_RECUR_EDIT_NOTE'] = 'Note: This is a recurring event. Editing this event will affect all other occurances.';
        $this->contents['LANG_EDIT_EVENT'] = 'Edit Event';
        $this->contents['LANG_SAVE_EVENT'] = 'Save Event';
        $this->contents['LANG_CLOSE'] = 'Close';
        $this->contents['LANG_DELETE_EVENT'] = 'Delete Event';
        $this->contents['LANG_CONFIRM_DELETE_EVENT'] = 'Are you sure you want to delete this event? This action cannot be undone.';
        $this->contents['LANG_EVENT_NOT_FOUND'] = 'Event Not Found';
        $this->contents['LANG_EVENT_NOT_FOUND_MSG'] = '<strong>The event you are looking for cannot be found.
                                                       It might have been shifted or deleted recently by someone.</strong>
                                                       <p>Try refreshing the page to get the most updated changes.</p>';
        $this->contents['LANG_MANAGE_LABELS'] = 'Manage Labels';
        $this->contents['LANG_IM_DONE'] = 'I\'m Done!';
        $this->contents['LANG_DESCRIPT'] = 'Description';
        $this->contents['LANG_START'] = 'Start Date/Time';
        $this->contents['LANG_END'] = 'End Date/Time';
        $this->contents['LANG_EVENT_LABEL'] = 'Event Label';
        $this->contents['LANG_REPEAT'] = 'Repeat';
        $this->contents['LANG_EVERY'] = 'Every';
        $this->contents['LANG_TIMES'] = 'Times';
        $this->contents['LANG_DATE'] = 'Date';
        $this->contents['LANG_END_REPEAT'] = 'End Repeat';
        $this->contents['LANG_VIEW_RSVP'] = 'View or RSVP';
        $this->contents['LANG_LOCATION'] = 'Location';
        $this->contents['LANG_RSVP'] = 'RSVP';
        $this->contents['LANG_SET_REMINDER'] = 'Set Reminder';
        $this->contents['LANG_SET_REPEAT'] = 'Set Repeat';
        $this->contents['LANG_EMAIL_REMINDER'] = 'Email';
        $this->contents['LANG_POPUP_REMINDER'] = 'Popup';
        $this->contents['LANG_ENTER_TITLE'] = 'Please enter an event title.';
        $this->contents['LANG_APPROVE'] = 'Approve';
        $this->contents['LANG_DISAPPROVE'] = 'Disapprove';
        $this->contents['LANG_APPROVED_BY'] = 'Approved by';
        $this->contents['LANG_DISAPPROVED_BY'] = 'Disapproved by';
        $this->contents['LANG_NO_PERM'] = "Sorry, you do not have the permission to edit this event.\nPlease seek an Administrator or the creator of this event for help.";

        $this->contents['LANG_SUBJECT'] = 'Approval For New Event';
        $this->contents['LANG_MESSAGE'] = 'Calendar Settings';
        $this->contents['LANG_SUBMIT_FOR_APPROVAL'] = 'Your event has been submitted for approval. Once your event has been approved, it will be display in the calendar.';

        $this->contents['LANG_GENERAL'] = 'General';
        $this->contents['LANG_REMINDER_REPEAT'] = 'Reminder / Repeat';
        $this->contents['LANG_NUM_ATTACHMENT'] = '{n} Attachment|Attachments';
        //$this->contents['LANG_ATTACH_FILES'] = 'Attach Files';
        //$this->contents['LANG_INVITE_STAFF'] = 'Invite Staff';

        $this->contents['LANG_PRIVACY_SETTING'] = 'Privacy Setting';
        $this->contents['LANG_PUBLIC'] = 'Public';
        $this->contents['LANG_PRIVATE'] = 'Private';
        $this->contents['LANG_WRITE_MESSAGE'] = 'Write a message';

        // Agenda
        $this->contents['LANG_DESCRIPTION'] = 'Description';
        $this->contents['LANG_UNTIL'] = 'until';
        $this->contents['LANG_FULL_DAY'] = 'Full Day';
        $this->contents['LANG_PRIVATE_EVENT_BY'] = 'Private event by';
        $this->contents['LANG_PUBLIC_EVENT_BY'] = 'Public event by';
        $this->contents['LANG_EXPORT'] = 'Export';
	}
}
?>