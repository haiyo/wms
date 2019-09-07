<?php
namespace Markaxis\Leave;
use \Markaxis\Company\OfficeModel, \Markaxis\Employee\EmployeeModel, \Markaxis\Employee\LeaveTypeModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\User\UserModel, \Aurora\User\UserImageModel;
use \Library\Helper\Markaxis\ApplyForHelper, \Library\Util\Date;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveApplyView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveApplyView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $LeaveApplyModel;


    /**
    * LeaveApplyView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->LeaveApplyModel = LeaveApplyModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderApplyForm( ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        $LeaveTypeModel = LeaveTypeModel::getInstance( );

        $SelectListView = new SelectListView( );
        $leaveTypeList = $SelectListView->build( 'ltID', $LeaveTypeModel->getListByUserID( $empInfo['userID'] ),
                                                '', 'Select Leave Type' );
        $applyForList = $SelectListView->build( 'applyFor', ApplyForHelper::getL10nList( ), 1 );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_LEAVE_TYPE_LIST' => $leaveTypeList,
                       'TPL_APPLY_FOR_LIST' => $applyForList ) );

        if( $empInfo['officeID'] ) {
            $OfficeModel = OfficeModel::getInstance( );
            $officeInfo  = $OfficeModel->getByoID( $empInfo['officeID'] );
            $vars['TPLVAR_OPEN_TIME'] = $officeInfo['openTime'];
            $vars['TPLVAR_CLOSE_TIME'] = $officeInfo['closeTime'];
        }
        return array( 'js' => array( 'markaxis' => array( 'usuggest.js', 'applyLeave.js' ) ),
                      'sidebarCards' => $this->renderOnLeave( ),
                      'content' => $this->View->render( 'markaxis/leave/applyForm.tpl', $vars ) );
    }


    /**
     * Render Tab
     * @return string
     */
    public function renderOnLeave( ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        // Get office time shift
        $OfficeModel = OfficeModel::getInstance( );
        $officeInfo = $OfficeModel->getWorkingDaysByOfficeID( $empInfo['officeID'] );

        $vars['dynamic']['noUserToday'] = true;
        $vars['dynamic']['userToday'] = false;

        if( $officeInfo && !in_array( date('N'), $officeInfo ) ) {
            $vars['LANG_NOT_TODAY'] = $this->L10n->getContents('LANG_ITS_HOLIDAY');
        }
        else {
            $today = $this->LeaveApplyModel->getWhosOnLeave( date('Y-m-d') );
            $vars['TPLVAR_TODAY_COUNT'] = sizeof( $today );

            if( $vars['TPLVAR_TODAY_COUNT'] ) {
                $vars['dynamic']['noUserToday'] = false;

                $UserImageModel = UserImageModel::getInstance( );

                foreach( $today as $user ) {
                    $vars['dynamic']['userToday'][] = array( 'TPLVAR_PHOTO' => $UserImageModel->getImgLinkByUserID( $user['userID'] ) );
                }
            }
            else {
                $vars['LANG_NOT_TODAY'] = $this->L10n->getContents('LANG_NO_ONE_ON_LEAVE_TODAY');
            }
        }
        
        $vars['dynamic']['noUserTomorrow'] = true;
        $vars['dynamic']['userTomorrow'] = false;
        $tomorrowDay = date('N')+1;

        if( $officeInfo && !in_array( $tomorrowDay == 8 ? 1 : $tomorrowDay, $officeInfo ) ) {
            $vars['LANG_NOT_TOMORROW'] = $this->L10n->getContents('LANG_ITS_HOLIDAY');
        }
        else {
            $tomorrow = $this->LeaveApplyModel->getWhosOnLeave( date('Y-m-d', strtotime('+1 day') ) );

            $vars['TPLVAR_TOMORROW_COUNT'] = sizeof( $tomorrow );

            if( $vars['TPLVAR_TOMORROW_COUNT'] ) {
                $vars['dynamic']['noUserTomorrow'] = false;

                $UserImageModel = UserImageModel::getInstance( );

                foreach( $tomorrow as $user ) {
                    $vars['dynamic']['userTomorrow'][] = array( 'TPLVAR_PHOTO' => $UserImageModel->getImgLinkByUserID( $user['userID'] ) );
                }
            }
            else {
                $vars['LANG_NOT_TODAY'] = $this->L10n->getContents('LANG_NO_ONE_ON_LEAVE_TOMORROW');
            }
        }
        return $this->View->render( 'markaxis/leave/whosOnLeave.tpl', array_merge( $this->L10n->getContents( ), $vars ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderPendingAction( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $pendingAction = $this->LeaveApplyModel->getPendingAction( $userInfo['userID'] );

        if( $pendingAction ) {
            $vars = array_merge( $this->L10n->getContents( ), array( ) );

            foreach( $pendingAction as $row ) {
                $created = Date::timeSince( $row['created'] );

                $pdVars = array_merge( $this->L10n->getContents( ), array( ) );

                if( $row['reason'] ) {
                    $pdVars['dynamic']['reason'][] = array( 'TPLVAR_REASON' => $row['reason'] );
                }
                else {
                    $pdVars['dynamic']['reason'] = false;
                }
                $pdVars['TPLVAR_START_DATE'] = $row['startDate'];
                $pdVars['TPLVAR_END_DATE'] = $row['endDate'];
                $reason = $this->View->render( 'markaxis/leave/pending_description.tpl', $pdVars );

                $UserImageModel = UserImageModel::getInstance( );

                $vars['dynamic']['list'][] = array( 'TPLVAR_PHOTO' => $UserImageModel->getImgLinkByUserID( $row['userID'] ),
                                                    'TPLVAR_FNAME' => $row['fname'],
                                                    'TPLVAR_LNAME' => $row['lname'],
                                                    'TPLVAR_TIME_AGO' => $created,
                                                    'TPLVAR_ID' => $row['laID'],
                                                    'TPLVAR_GROUP_NAME' => 'leave',
                                                    'TPLVAR_CLASS' => 'leaveAction',
                                                    'TPLVAR_TITLE' => $row['name'] . ' (' . $row['code'] . ')',
                                                    'TPLVAR_DESCRIPTION' => $reason,
                                                    'TPLVAR_VALUE' => $row['days'] . ' ' . $this->L10n->getContents('LANG_DAYS'),
                                                    'TPLVAR_ATTACHMENT' => '' );

                return $this->View->render( 'aurora/page/tableRowRequest.tpl', $vars );
            }
        }
    }
}
?>