<?php
namespace Markaxis\Calendar;
use \Aurora\User\UserModel;
use \Library\Helper\Markaxis\LabelHelper;
use \Library\Helper\Markaxis\RecurHelper, \Library\Helper\Markaxis\ReminderHelper;
use \Library\Validator\Validator;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarModel extends \Model {


    //properties
    protected $Calendar;


        /**
    * CalendarModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Calendar/EventRes');

        $this->Calendar = new Calendar( );

        $this->info['eID']         = 0;
        $this->info['title']       = '';
        $this->info['descript']    = '';
        $this->info['label']       = 'blue';
        $this->info['privacy']     = 0;
        $this->info['allDay']      = 0;
        $this->info['start']       = '';
        $this->info['end']         = '';
        $this->info['reminder']    = 0;
        $this->info['recurType']   = 0;
	}


    /**
    * Retrieve Calendar info by default
    * @return mixed
    */
    public function getCalByDefault( ) {
        return $this->Calendar->getCalByDefault( $this->userInfo['userID'] );
    }


    /**
    * Get Calendar info By calID
    * @return mixed[]
    */
    public function getByCalID( $calID ) {
        return $this->Calendar->getByCalID( $calID );
    }


    /**
     * Retrieve Labels by UserID
     * @return mixed
     */
    public function getLabels( ) {
        $Label = new Label( );
        return $Label->getLabels( );
    }


    /**
    * Get Owner Calendar
    * @return mixed[]
    */
    public function getOwnerCal( ) {
        $calInfo = $this->getByCalID( $this->info['calID'] );

        if( $calInfo['parentID'] != 0 ) {
            // Get real owner
            $calInfo = $this->getByCalID( $calInfo['parentID'] );
        }
        return $calInfo;
    }


    /**
    * Check if user can manage sharing on calendar
    * @return bool
    */
    public function getCalPerm( $calInfo ) {
        if( $calInfo['parentID'] != 1 ) { // not public
            if( $calInfo['ownerID'] == $this->userInfo['userID'] ) {
                return 'changeShare';
            }
            $setInfo = unserialize( $calInfo['settings'] );

            if( isset( $setInfo['people'] ) ) {
                foreach( $setInfo['people'] as $userID => $value ) {
                    if( $userID == $this->userInfo['userID'] ) {
                        return $value['perm'];
                    }
                }
            }
        }
        return false;
    }


    /**
    * Set new event info on date selection (prepare for form)
    * @return void
    */
    public function setNewEventInfo( $info ) {
        // NOTE: We allow info to be empty during scenerio when user updating labels.
        // The form original value will be populated on the client side (javascript).
        if( isset( $info[1] ) ) $this->info['calID']  = $info[1];
        if( isset( $info[2] ) ) $this->info['start']  = $info[2];
        if( isset( $info[3] ) ) $this->info['end']    = $info[3];
        if( isset( $info[4] ) ) $this->info['allDay'] = $info[4];
    }


    /**
    * Get all events by calID
    * @return mixed[]
    */
    public function getEventIDByCalID( $calID ) {
        return $this->Calendar->getEventIDByCalID( $calID );
    }


    /**
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    */
    public function getTableList( ) {
        return $this->Calendar->getTableList( );
    }
}
?>