<?php
namespace Markaxis\Leave;
use \Library\Util\Date;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: HolidayModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HolidayModel extends \Model {


    // Properties
    protected $Holiday;


    /**
     * HolidayModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->Holiday = new Holiday( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByhID( $hID ) {
        return $this->Holiday->isFoundByhID( $hID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByhID( $hID ) {
        return $this->Holiday->getByhID( $hID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getAll( ) {
        return $this->Holiday->getAll( );
    }


    /**
     * Retrieve Events Between a Start and End Timestamp
     * @return mixed
     */
    public function getEvents( $info ) {
        $eventList = array( );

        if( isset( $info['start'] ) && isset( $info['end'] ) ) {
            $startDate = Date::parseDateTime( $info['start'] );
            $endDate = Date::parseDateTime( $info['end'] );

            $eventList = $this->Holiday->getEventsBetween( $startDate, $endDate );
        }
        return $eventList;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Holiday->setLimit( $post['start'], $post['length'] );

        $order = 'h.date';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'asc' ? ' asc' : ' desc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'h.title';
                    break;
                case 2:
                    $order = 'h.date';
                    break;
            }
        }
        $results = $this->Holiday->getResults( $post['search']['value'], $order . $dir );
        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function saveHoliday( $data ) {
        $hID = (int)$data['hID'];
        $this->info['title'] = Validator::stripTrim( $data['holidayTitle'] );
        $this->info['date'] = \DateTime::createFromFormat('d M Y', $data['date'] );
        $this->info['workDay'] = ( isset( $data['workDay']  ) && $data['workDay']  ) ? 1 : 0;

        if( !$this->info['title'] || !$this->info['date'] ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED_FIELDS') );
            return false;
        }
        else {
            $this->info['date'] = $this->info['date']->format('Y-m-d');

            if( $hID && $this->isFoundByhID( $hID ) ) {
                $this->Holiday->update( 'holiday', $this->info, 'WHERE hID = "' . (int)$hID . '"' );
                $this->info['hID'] = $hID;
            }
            else {
                $this->info['hID'] = $this->Holiday->insert('holiday', $this->info );
            }
        }
        return $this->info['hID'];
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deleteHoliday( $data ) {
        if( isset( $data['hID'] ) ) {
            return $this->Holiday->delete('holiday', 'WHERE hID = "' . (int)$data['hID'] . '"');
        }
    }
}
?>