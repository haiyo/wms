<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\EmployeeModel;
use \Markaxis\Employee\LeaveBalanceModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Library\Helper\Markaxis\ApplyForHelper;
use \Markaxis\Employee\ManagerModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $LeaveModel;


    /**
    * LeaveView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->LeaveModel = LeaveModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string

    public function renderApplyForm( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $SelectListView = new SelectListView( );
        $leaveTypeList = $SelectListView->build( 'ltID', $this->LeaveModel->getTypeListByUserID( $userInfo['userID'] ),
                                                '', 'Select Leave Type' );
        $applyForList = $SelectListView->build( 'applyFor', ApplyForHelper::getL10nList( ), 1 );

        $ManagerModel = ManagerModel::getInstance( );
        $managers = $ManagerModel->getSuggestToken( $userInfo['userID'] );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_LEAVE_TYPE_LIST' => $leaveTypeList,
                       'TPL_APPLY_FOR_LIST' => $applyForList,
                       'TPLVAR_MANAGERS' => $managers['name'] ) );

        return array( 'js' => array( 'markaxis' => 'applyLeave.js' ),
                      'content' => $this->render( 'markaxis/leave/applyForm.tpl', $vars ) );
    } */


    /**
     * Render main navigation
     * @return string
     */
    public function renderBalance( ) {
        $this->View->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js',
                                                                              'checkboxes.min.js',
                                                                              'mark.min.js'),
                                        'plugins/visualization/d3' => array( 'd3.min.js', 'd3_tooltip.js' ),
                                        'jquery' => array( 'mark.min.js' ) ) );

        $vars = array_merge( $this->L10n->getContents( ), array( ) );

        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'mi-schedule',
                                            'text' => $this->L10n->getContents('LANG_LEAVE_BALANCE_STATUS') ) );

        $vars['dynamic']['balChart'] = false;

        $TypeModel = TypeModel::getInstance( );
        $chartList = $TypeModel->getByChart( );

        $LeaveBalanceModel = LeaveBalanceModel::getInstance( );
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        foreach( $chartList as $ltID => $name ) {
            $balInfo = $LeaveBalanceModel->getByltIDUserID( $ltID, $empInfo['userID'] );

            if( $balInfo ) {
                $vars['dynamic']['balChart'][] = array( 'TPLVAR_LEAVE_NAME' => $name,
                    'TPLVAR_BALANCE' => $balInfo['balance'],
                    'TPLVAR_TOTAL_APPLIED' => $balInfo['totalApplied'],
                    'TPLVAR_TOTAL_LEAVES' => $balInfo['totalLeaves'] );
            }
        }

        $this->View->printAll( $this->View->render( 'markaxis/leave/balance.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( $form ) {
        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_FORM' => $form ) );

        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-cog2',
                                            'text' => $this->L10n->getContents('LANG_LEAVE_SETTINGS') ) );

        $this->View->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js'),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );

        $this->View->printAll( $this->View->render( 'markaxis/leave/settings.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderTypeForm( $form, $ltID=0 ) {
        $this->View->setJScript( array( 'plugins/forms' => array( 'wizards/stepy.min.js' ),
                                        'plugins/forms/selects' => array( 'bootstrap_multiselect.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_LEAVE_TYPE_ID' => $ltID,
                       'TPL_FORM' => $form ) );

        $this->View->setBreadcrumbs( array( 'link' => 'settings',
                                            'icon' => 'icon-cog2',
                                            'text' => $this->L10n->getContents('LANG_LEAVE_SETTINGS') ) );

        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-file-plus2',
                                            'text' => $this->L10n->getContents('LANG_CREATE_NEW_LEAVE_TYPE') ) );

        $this->View->printAll( $this->View->render( 'markaxis/leave/typeFormWrapper.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderDateDiff( $data ) {
        if( isset( $data['startDate'] ) && isset( $data['endDate'] ) && $data['startDate'] && $data['endDate'] ) {
            $days = (int)$this->LeaveModel->getDateDiff( $data['startDate'], $data['endDate'] );

            return array( 'days' => $days,
                          'text' => $this->L10n->getText( 'LANG_APPLY_DAYS', $days ) );
        }
    }
}
?>