<?php
namespace Markaxis\Training;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TrainingRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TrainingRes extends Resource {


    // Properties


    /**
     * TrainingRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_TRAINING_COURSES'] = 'Training &amp; Courses';
    }
}
?>