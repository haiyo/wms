<?php
namespace Markaxis;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PostJobRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PostJobRes extends Resource {


    // Properties


    /**
     * PostJobRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_POST_A_JOB'] = 'Post A Job';
        $this->contents['LANG_INTERNAL_JOB_POSTING'] = 'Internal Job Posting';
    }
}
?>