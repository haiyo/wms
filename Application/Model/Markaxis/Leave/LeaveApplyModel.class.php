<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\EmployeeModel;
use \Markaxis\Company\OfficeModel;
use \Library\Util\Date, \Library\Util\Formula;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveApplyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveApplyModel extends \Model {


    // Properties
    protected $LeaveApply;



    /**
     * LeaveApplyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->LeaveApply = new LeaveApply( );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function isFoundByLaIDUserID( $laID, $userID, $status ) {
        return $this->LeaveApply->isFoundByLaIDUserID( $laID, $userID, $status );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function isFoundByUserID( $userID, $status ) {
        return $this->LeaveApply->isFoundByUserID( $userID, $status );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getUnPaidByUserID( $userID ) {
        return $this->LeaveApply->getUnPaidByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByUserLeaveTypeCurrYear( $userID, $leaveTypes ) {
        foreach( $leaveTypes as $key => $type ) {
            $leaveApplied = $this->LeaveApply->getByUserLeaveTypeCurrYear( $userID, $type['ltID'] );

            if( sizeof( $leaveApplied ) > 0 ) {
                //$currYear = date('Y');
                $leaveTypes[$key]['totalApplied'] = 0;

                foreach( $leaveApplied as $applied ) {
                    $leaveTypes[$key]['totalApplied'] += $applied['days'];

                    /* $endDate = \DateTime::createFromFormat('Y-m-d', $applied['endDate'] );

                    if( $endDate->format('Y') == $currYear ) {
                        $leaveTypes[$key]['totalApplied'] += $applied['days'];
                    }
                    // Leave applied endDate overlap to next year
                    else if( $endDate->format('Y') > $currYear ) {
                        $startDate = \DateTime::createFromFormat('Y-m-d', $applied['startDate'] );
                        $period = new \DatePeriod( $startDate, new \DateInterval('P1D'), $endDate );
                        $leaveTypes[$key]['totalApplied'] = 0;

                        foreach( $period as $dt ) {
                            if( $dt->format('Y') == $currYear ) {
                                $leaveTypes[$key]['totalApplied']++;
                            }
                            else {
                                break;
                            }
                        }
                        if( $applied['firstHalf'] ) {
                            $leaveTypes[$key]['totalApplied'] -= .5;
                        }
                    }*/
                }
            }
        }
        return $leaveTypes;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getPendingAction( $userID ) {
        return $this->LeaveApply->getPendingAction( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getWhosOnLeave( $date ) {
        return $this->LeaveApply->getWhosOnLeave( $date );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getEvents( $post ) {
        $eventList = array( );

        if( isset( $post['start'] ) && isset( $post['end'] ) ) {
            $startDate = Date::parseDateTime( $post['start'] );
            $endDate = Date::parseDateTime( $post['end'] );
            $eventList = $this->LeaveApply->getEvents( $startDate, $endDate );

            foreach( $eventList as $key => $event ) {
                $eventList[$key]['title'] = $event['name'] . ' - ' . $event['title'];
            }
        }
        return $eventList;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getHistory( $post ) {
        $this->LeaveApply->setLimit( $post['start'], $post['length'] );

        $order = 'la.created';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'lt.name';
                    break;
                case 2:
                    $order = 'la.reason';
                    break;
                case 3:
                    $order = 'la.approved';
                    break;
                case 4:
                    $order = 'la.created';
                    break;
            }
        }
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );
        $results = $this->LeaveApply->getHistory( $empInfo['userID'], $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function setStatus( $laID, $status ) {
        $this->LeaveApply->update('leave_apply', array( 'status' => $status ),
                                  'WHERE laID = "' . (int)$laID . '"' );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $userID, $processDate, $data ) {
        $applyInfo    = $this->getUnPaidByUserID( $userID );
        $totalApplied = sizeof( $applyInfo );
        $processDate  = \DateTime::createFromFormat('Y-m-d', $processDate );

        if( $totalApplied > 0 ) {
            $EmployeeModel = EmployeeModel::getInstance( );
            $empInfo = $EmployeeModel->getFieldByUserID( $userID, 'officeID, salary' );

            $OfficeModel = OfficeModel::getInstance( );
            $workDays  = $OfficeModel->getWorkingDaysByRange( $processDate->format('Y-m-') . '01',
                                                              $processDate->format('Y-m-') . $processDate->format('t'),
                                                              $empInfo['officeID'] );

            $daysWorked = ($workDays-$totalApplied);

            foreach( $applyInfo as $value ) {
                //{salary}*{daysWorkedInMonth}/{workDaysOfMonth}
                $formula = str_replace('{salary}', $empInfo['salary'], $value['formula'] );
                $formula = str_replace('{workDaysOfMonth}', $workDays, $formula );
                $formula = str_replace('{daysWorkedInMonth}', $daysWorked, $formula );

                // AW Ceiling
                $Formula = new Formula( );
                $salary = round( $Formula->calculate( $formula ) );
                $amount = $empInfo['salary']-$salary;
                $remark = $value['name'];

                $data['items'][] = array( 'hiddenName' => 'leaveApply[]',
                                          'hiddenValue' => $value['laID'],
                                          'hiddenID' => 'leaveApply' . $value['laID'],
                                          'piID' => $data['deduction']['piID'],
                                          'remark' => $remark,
                                          'amount' => $amount );
            }
        }
        return $data;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( $data ) {
        $firstHalf  = ( isset( $data['firstHalf']  ) && $data['firstHalf']  ) ? 1 : 0;
        $secondHalf = ( isset( $data['secondHalf'] ) && $data['secondHalf'] ) ? 1 : 0;

        $this->info['userID'] = $data['userID'];
        $this->info['ltID'] = $data['ltID'];
        $this->info['reason'] = $data['reason'];
        $this->info['startDate'] = $data['startDate']->format('Y-m-d');
        $this->info['endDate'] = $data['endDate']->format('Y-m-d');
        $this->info['firstHalf'] = $firstHalf;
        $this->info['secondHalf'] = $secondHalf;
        $this->info['days'] = $data['days'];
        $this->info['created'] = date( 'Y-m-d H:i:s' );
        return $this->info['laID'] = $this->LeaveApply->insert('leave_apply', $this->info );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data, $post ) {
        if( isset( $data['empInfo'] ) && isset( $post['data']['leaveApply'] ) && is_array( $post['data']['leaveApply'] ) ) {
            foreach( $post['data']['leaveApply'] as $laID ) {
                if( $this->isFoundByLaIDUserID( $laID, $data['empInfo']['userID'],1 ) ) {
                    $this->LeaveApply->update('leave_apply', array( 'status' => 2 ),
                                              'WHERE laID = "' . (int)$laID . '"' );
                }
            }
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['empInfo']['userID'] ) && $this->isFoundByUserID( $data['empInfo']['userID'],2 ) ) {
            $this->LeaveApply->update('leave_apply', array( 'status' => 1 ),
                                      'WHERE userID = "' . (int)$data['empInfo']['userID'] . '" AND
                                                    status = "2"' );
        }
    }
}
?>