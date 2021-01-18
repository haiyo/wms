<?php
namespace Markaxis\Cron;
use \Aurora\Admin\CronControl;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: LeaveControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
class LeaveControl extends CronControl {


    // Properties


    /**
     * LeaveControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->setup( );
        new LeaveModel( );
    }
}
?>