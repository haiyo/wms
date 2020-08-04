<?php
namespace Markaxis\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LabelRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LabelRes extends Resource {


    /**
    * LabelRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_BUSINESS'] = 'Business';
        $this->contents['LANG_IMPORTANT'] = 'Important';
        $this->contents['LANG_PREPARATION'] = 'Preparation';
        $this->contents['LANG_PERSONAL'] = 'Personal';
        $this->contents['LANG_BIRTHDAY'] = 'Birthday';
        $this->contents['LANG_MUST_ATTEND'] = 'Must Attend';
        $this->contents['LANG_PHONE_CALL'] = 'Phone Call';
        $this->contents['LANG_VACATION'] = 'Vacation';
        $this->contents['LANG_ANNIVERSARY'] = 'Anniversary';
        $this->contents['LANG_TRAVEL'] = 'Travel';
        $this->contents['LANG_MANAGE_LABEL'] = 'Manage Labels';
	}
}
?>