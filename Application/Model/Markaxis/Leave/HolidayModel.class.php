<?php
namespace Markaxis\Leave;
use \Library\Helper\Markaxis\PaidLeaveHelper;
use \Library\Helper\Markaxis\HalfDayHelper;
use \Library\Helper\Markaxis\LeavePeriodHelper;
use \Library\Helper\Markaxis\UnusedLeaveHelper;
use \Library\Helper\Markaxis\CarryPeriodHelper;
use \Library\Helper\Aurora\YesNoHelper;
use \Library\Validator\Validator;
use \Library\Util\Date;

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
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Holiday = new Holiday( );

        $this->info['name'] = '';
        $this->info['date'] = '';
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->Holiday->isFound( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $ltID ) {
        return $this->info = $this->Type->getByID( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByIDs( $ltIDs ) {
        return $this->Type->getByIDs( $ltIDs );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Type->getList( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getEvents( $post ) {
        if( isset( $post['start'] ) && isset( $post['end'] ) ) {
            $startDate = Date::parseDateTime( $post['start'] );
            $endDate = Date::parseDateTime( $post['end'] );
            return $this->Holiday->getEvents( $startDate, $endDate );
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Holiday->setLimit( $post['start'], $post['length'] );

        $order = 'h.date';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

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
    public function save( $data ) {
        $this->info = array( );
        $this->info['name'] = Validator::stripTrim( $data['leaveTypeName'] );
        $this->info['code'] = Validator::stripTrim( $data['leaveCode'] );

        if( isset( $data['formula'] ) ) {
            $this->info['formula'] = Validator::stripTrim( $data['formula'] );
        }

        if( isset( $data['paidLeave'] ) && isset( PaidLeaveHelper::getL10nList( )[$data['paidLeave']] ) ) {
            $this->info['paidLeave'] = (int)$data['paidLeave'];
        }
        if( isset( $data['allowHalfDay'] ) && isset( HalfDayHelper::getL10nList( )[$data['allowHalfDay']] ) ) {
            $this->info['allowHalfDay'] = (int)$data['allowHalfDay'];
        }
        if( isset( $data['showChart'] ) && isset( YesNoHelper::getL10nList( )[$data['showChart']] ) ) {
            $this->info['showChart'] = (int)$data['showChart'];
        }

        if( isset( UnusedLeaveHelper::getL10nList( )[$data['unused']] ) ) {
            $this->info['unused'] = $data['unused'];

            if( $this->info['unused'] == 'carry' ) {
                $cPeriodValue = (int)$data['cPeriodValue'];
                $usedValue = (int)$data['usedValue'];

                if( $cPeriodValue > 0 && isset( CarryPeriodHelper::getL10nList( )[$data['cPeriodType']] ) ) {
                    $this->info['cPeriod'] = $cPeriodValue;
                    $this->info['cPeriodType'] = $data['cPeriodType'];

                    if( $usedValue > 0 && isset( LeavePeriodHelper::getL10nList( )[$data['usedType']] ) ) {
                        $this->info['uPeriod'] = $usedValue;
                        $this->info['uPeriodType'] = $data['usedType'];
                    }
                }
            }
        }

        if( $data['ltID'] && $this->isFound( $data['ltID'] ) ) {
            $ltID = (int)$data['ltID'];
            $this->Type->update( 'leave_type', $this->info, 'WHERE ltID = "' . $ltID . '"' );
        }
        else {
            $ltID = $this->Type->insert('leave_type', $this->info);
        }
        return $ltID;
    }
}
?>