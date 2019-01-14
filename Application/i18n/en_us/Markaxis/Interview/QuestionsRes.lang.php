<?php
namespace Markaxis;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: QuestionsRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class QuestionsRes extends Resource {


    // Properties


    /**
     * QuestionsRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_ALUMNI_MANAGEMENT'] = 'Questions Management';
    }
}
?>