<?php
namespace Markaxis\Cron;
use \Aurora\Admin\AdminControl;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: HolidayControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
class HolidayControl extends AdminControl {


    // Properties
    protected $HolidayModel;


    /**
     * ControlPanelControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->connectDB( );

        $this->HolidayModel = new HolidayModel( );
    }
}
?>