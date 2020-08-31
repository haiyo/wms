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
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_KNOWLEDGE_BASE'] = 'Kiến thức cơ bản';
        $this->contents['LANG_CONTACT_HELPDESK'] = 'Liên hệ bộ phận trợ giúp';
        $this->contents['LANG_USER_GUIDE'] = 'Hướng dẫn sử dụng';
        $this->contents['LANG_FREQUENTLY_ASKED_QUESTIONS'] = 'Các câu hỏi thường gặp';
    }
}
?>