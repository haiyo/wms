<?php
namespace Markaxis;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: HelpRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HelpRes extends Resource {


    // Properties


    /**
     * HelpRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_KNOWLEDGE_BASE'] = 'Knowledge Base';
        $this->contents['LANG_CONTACT_HELPDESK'] = 'Contact Helpdesk';
        $this->contents['LANG_USER_GUIDE'] = 'User Guide';
        $this->contents['LANG_FREQUENTLY_ASKED_QUESTIONS'] = 'Frequently Asked Questions';
    }
}
?>