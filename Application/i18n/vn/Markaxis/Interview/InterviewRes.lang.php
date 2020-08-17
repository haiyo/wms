<?php
namespace Markaxis;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: InterviewRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class InterviewRes extends Resource {


    // Properties


    /**
     * InterviewRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_INTERVIEW_TOOLKIT'] = 'Interview Toolkit';
    }
}
?>