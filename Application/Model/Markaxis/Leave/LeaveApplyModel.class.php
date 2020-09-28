<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\EmployeeModel;
use \Markaxis\Company\OfficeModel;
use \Aurora\Component\UploadModel;
use \Library\Util\Uploader, \Library\Util\Date, \Library\Util\Formula;

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
    public function getUnPaidByUserID( $userID, $startDate='', $endDate='' ) {
        return $this->LeaveApply->getUnPaidByUserID( $userID, $startDate, $endDate );
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
     * Return total count of records
     * @return int
     */
    public function getRequest( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        return $this->LeaveApply->getRequest( $userInfo['userID'] );
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
    public function getEvents( $info ) {
        $eventList = array( );

        if( isset( $info['start'] ) && isset( $info['end'] ) ) {
            $startDate = Date::parseDateTime( $info['start'] );
            $endDate = Date::parseDateTime( $info['end'] );
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

        foreach( $results as $key => $row ) {
            $results[$key]['created'] = '<div class="text-muted text-size-small">' . Date::timeSince( $row['created'] ) . '</div>';
        }

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
    public function cancel( $laID ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $this->LeaveApply->update('leave_apply', array( 'cancelled' => 1 ),
                                  'WHERE laID = "' . (int)$laID . '" AND userID = "' . $userInfo['userID'] . '"' );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $data ) {
        if( isset( $data['payCal']['rangeStart'] ) && isset( $data['payCal']['rangeEnd'] ) && isset( $data['office']['workDaysOfMonth'] ) ) {

            $rangeStart = $data['payCal']['rangeStart']->format('Y-m-d');
            $rangeEnd   = $data['payCal']['rangeEnd']->format('Y-m-d');
            $applyInfo  = $this->getUnPaidByUserID( $data['empInfo']['userID'], $rangeStart, $rangeEnd );

            if( sizeof( $applyInfo ) > 0 ) {
                $OfficeModel = OfficeModel::getInstance( );

                $totalUnpaidDays = 0;

                foreach( $applyInfo as $row ) {
                    $leaveStartDate = new \DateTime( $row['startDate'] );
                    $leaveEndDate   = new \DateTime( $row['endDate'] );

                    // if unpaid leave is within the process month,
                    // then we just trust the days since already calculated properly when apply leave.
                    if( $leaveStartDate >= $data['payCal']['rangeStart'] && $leaveEndDate <= $data['payCal']['rangeEnd'] ) {
                        $totalUnpaidDays += $row['days'];
                    }
                    else {
                        // At this point we need to make sure weekend(s) and holidays are cater for.

                        // if unpaid leave start within this process date but end the next process date.
                        // (Eg: March is current month: 29th Mar - 5th Apr)
                        if( $leaveStartDate >= $data['payCal']['rangeStart'] && $leaveEndDate > $data['payCal']['rangeEnd'] ) {
                            // Calculate only until $leaveStartDate to $processEndDate
                            $totalUnpaidDays = $OfficeModel->getWorkingDaysByRange( $data['empInfo']['officeID'],
                                                                                    $row['startDate'],
                                                                                    $data['payCal']['rangeEnd']->format('Y-m-d') );
                        }
                        // if start leave is previous month and end is within this month.
                        // (Eg: March current month: 28th Feb - 5th Mar)
                        else if( $leaveStartDate < $data['payCal']['rangeStart'] && $leaveEndDate <= $data['payCal']['rangeEnd'] ) {
                            // Calculate only until $processStartDate to $leaveEndDate
                            $totalUnpaidDays = $OfficeModel->getWorkingDaysByRange( $data['empInfo']['officeID'],
                                                                                    $data['payCal']['rangeStart']->format('Y-m-d'),
                                                                                    $row['endDate'] );
                        }
                    }
                }

                foreach( $applyInfo as $value ) {
                    //{salary}*{daysWorkedInMonth}/{workDaysOfMonth}
                    $formula = str_replace('{salary}', $data['items']['totalOrdinary'], $value['formula'] );
                    $formula = str_replace('{workDaysOfMonth}', $data['office']['workDaysOfMonth'], $formula );
                    $formula = str_replace('{daysWorkedInMonth}', $totalUnpaidDays, $formula );

                    $Formula = new Formula( );
                    $totalUnpaidAmount = round( $Formula->calculate( $formula ) );
                    $remark = $value['name'];

                    $data['deductGross'][] = $totalUnpaidAmount;

                    $data['itemRow'][] = array( 'hiddenName' => 'leaveApply[]',
                                                'hiddenValue' => $value['laID'],
                                                'hiddenID' => 'leaveApply' . $value['laID'],
                                                'piID' => $data['items']['deduction']['piID'],
                                                //'triD'
                                                'amount' => $totalUnpaidAmount,
                                                'disabled' => 1,
                                                'remark' => $remark . ' (' . $this->L10n->getText( 'LANG_APPLY_DAYS', $totalUnpaidDays ) . ')' );
                }
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


    /**
     * Upload file
     * @return bool
     */
    public function uploadSuccess( $laID, $file ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( $this->isFoundByLaIDUserID( $laID, $userInfo['userID'],0 ) ) {
            $Uploader = new Uploader([
                'uploadDir' => USER_LEAVE_DIR
            ]);

            if( $Uploader->validate( $file['file_data'] ) && $Uploader->upload( ) ) {
                $fileInfo = $Uploader->getFileInfo( );

                $UploadModel = new UploadModel( );
                $fileInfo['uID'] = $UploadModel->saveUpload( $fileInfo );

                if( $fileInfo['error'] ) {
                    $this->setErrMsg( $fileInfo['error'] );
                    return false;
                }

                if( $fileInfo['success'] == 2 && $fileInfo['isImage'] ) {
                    $UploadModel->processResize( $fileInfo );
                }
                $this->LeaveApply->update('leave_apply', array( 'uID' => $fileInfo['uID'] ),
                                          'WHERE laID = "' . (int)$laID . '"' );

                return true;
            }
            $this->setErrMsg( $Uploader->getFileInfo( )['error'] );
            return false;
        }
    }
}
?>