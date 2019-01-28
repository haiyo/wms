<?php
namespace Markaxis\Leave;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\User\UserModel;
use \Library\Helper\Markaxis\ApplyForHelper;
use \Markaxis\Employee\SupervisorModel;
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

        $LeaveApplyModel = LeaveApplyModel::getInstance( );
        $this->LeaveApplyModel = $LeaveApplyModel;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderApplyForm( ) {
        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        $SelectListView = new SelectListView( );
        $leaveTypeList = $SelectListView->build( 'ltID', $this->LeaveModel->getTypeListByUserID( $userInfo['userID'] ),
                                                '', 'Select Leave Type' );
        $applyForList = $SelectListView->build( 'applyFor', ApplyForHelper::getL10nList( ), 1 );

        $SupervisorModel = SupervisorModel::getInstance( );
        $supervisors = $SupervisorModel->getNameByUserID( $userInfo['userID'] );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_LEAVE_TYPE_LIST' => $leaveTypeList,
                       'TPL_APPLY_FOR_LIST' => $applyForList,
                       'TPLVAR_SUPERVISORS' => $supervisors['name'] ) );

        return array( 'js' => array( 'markaxis' => 'applyLeave.js' ),
                      'content' => $this->render( 'markaxis/leave/applyForm.tpl', $vars ) );
    }
}
?>