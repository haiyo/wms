<?php
namespace Markaxis\Leave;
use \Markaxis\Company\OfficeModel, \Markaxis\Employee\EmployeeModel, \Markaxis\Employee\LeaveTypeModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\User\UserModel;
use \Library\Helper\Markaxis\ApplyForHelper, \Library\Util\Date;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveApplyView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveApplyView extends AdminView {


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
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->LeaveApplyModel = LeaveApplyModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderApplyForm( ) {
        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        $LeaveTypeModel = LeaveTypeModel::getInstance( );

        $SelectListView = new SelectListView( );
        $leaveTypeList = $SelectListView->build( 'ltID', $LeaveTypeModel->getListByUserID( $userInfo['userID'] ),
                                                '', 'Select Leave Type' );
        $applyForList = $SelectListView->build( 'applyFor', ApplyForHelper::getL10nList( ), 1 );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_LEAVE_TYPE_LIST' => $leaveTypeList,
                       'TPL_APPLY_FOR_LIST' => $applyForList ) );

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        if( $empInfo['officeID'] ) {
            $OfficeModel = OfficeModel::getInstance( );
            $officeInfo  = $OfficeModel->getByoID( $empInfo['officeID'] );
            $vars['TPLVAR_OPEN_TIME'] = $officeInfo['openTime'];
            $vars['TPLVAR_CLOSE_TIME'] = $officeInfo['closeTime'];
        }
        return array( 'js' => array( 'markaxis' => array( 'usuggest.js', 'applyLeave.js' ) ),
                      'content' => $this->render( 'markaxis/leave/applyForm.tpl', $vars ) );
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
                $pdVars['TPLVAR_REASON'] = $row['reason'];
                $pdVars['TPLVAR_START_DATE'] = $row['startDate'];
                $pdVars['TPLVAR_END_DATE'] = $row['endDate'];
                $pdVars['TPLVAR_DAYS'] = $row['days'];
                $reason = $this->render( 'markaxis/leave/pending_description.tpl', $pdVars );

                $vars['dynamic']['list'][] = array( 'TPLVAR_FNAME' => $row['fname'],
                                                    'TPLVAR_LNAME' => $row['lname'],
                                                    'TPLVAR_TIME_AGO' => $created,
                                                    'TPLVAR_ID' => $row['laID'],
                                                    'TPLVAR_CLASS' => 'leaveAction',
                                                    'TPLVAR_TITLE' => $row['name'] . ' (' . $row['code'] . ')',
                                                    'TPLVAR_DESCRIPTION' => $reason );

                return $this->render( 'aurora/page/tableRowRequest.tpl', $vars );
            }
        }
    }
}
?>