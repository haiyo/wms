<?php
namespace Markaxis\Leave;
use \Aurora\AuroraView, \Aurora\Form\SelectListView, \Aurora\User\UserModel;
use \Library\Helper\Markaxis\ApplyForHelper;
use \Markaxis\Employee\SupervisorModel;
use \Library\IO\File;
use \Library\Runtime\Registry;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveApplyView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveApplyView extends AuroraView {


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

        File::import( MODEL . 'Markaxis/Leave/LeaveApplyModel.class.php' );
        $LeaveApplyModel = LeaveApplyModel::getInstance( );
        $this->LeaveApplyModel = $LeaveApplyModel;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderApplyForm( ) {
        File::import( MODEL . 'Aurora/User/UserModel.class.php' );
        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        File::import( VIEW . 'Aurora/Form/SelectListView.class.php' );
        $SelectListView = new SelectListView( );
        $leaveTypeList = $SelectListView->build( 'ltID', $this->LeaveModel->getTypeListByUserID( $userInfo['userID'] ),
                                                '', 'Select Leave Type' );
        $applyForList = $SelectListView->build( 'applyFor', ApplyForHelper::getL10nList( ), 1 );

        File::import( MODEL . 'Markaxis/Employee/SupervisorModel.class.php' );
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