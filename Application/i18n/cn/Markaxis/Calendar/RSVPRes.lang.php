<?php
namespace Markaxis\Calendar;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: RSVPRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RSVPRes extends Resource {


    /**
    * RSVPRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_RSVP'] = 'RSVP';
        $this->contents['LANG_RSVP_COMMENTS'] = 'RSVP / Discussions';
        $this->contents['LANG_RETRIEVE_USER_TEXT'] = 'Retrieving user list...';
        $this->contents['LANG_NO_RECORDS_FOUND'] = 'No Records Found';
        $this->contents['LANG_SELECT_ROLE'] = '----- Select a role -----';
        $this->contents['LANG_RSVP_INSTRUCTIONS'] = 'Create this as an RSVP event. People you invited will receive notification and be able to choose whether they are attending this event or not.';
        $this->contents['LANG_SEARCH_NAME'] = 'Search by name';
        $this->contents['LANG_ATTENDING'] = 'Attending';
        $this->contents['LANG_NOT_ATTENDING'] = 'Not Attending';
        $this->contents['LANG_MAYBE'] = 'Maybe';
        $this->contents['LANG_NOT_YET_REPLIED'] = 'Not Yet Replied';
        $this->contents['LANG_INVITE_TO'] = '<strong>{username}</strong> invited you to {n} his|her event <strong>{event}</strong>';
        $this->contents['LANG_LOCATED_AT'] = 'located at <strong>{location}</strong>';
	}
}
?>