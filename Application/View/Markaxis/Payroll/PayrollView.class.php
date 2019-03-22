<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\EmployeeModel, \Aurora\Component\DepartmentModel, \Aurora\Component\ContractModel;
use \Aurora\User\UserImageModel, \Aurora\Component\DesignationModel, \Aurora\Component\PaymentMethodModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\Component\OfficeModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PayrollView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $PayrollModel;


    /**
    * PayrollView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->PayrollModel = PayrollModel::getInstance( );

        $this->setJScript( array( 'plugins/visualization' => 'echarts/echarts.min.js',
                                  'plugins/moment' => 'moment.min.js',
                                  'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                  'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                  'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                  'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js', 'widgets.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderOverview( ) {
        $vars = array( );
        $startDate = new \DateTime( date('Y-m-01') );
        $startDate = $startDate->modify( '-11 month' );
        $endDate   = new \DateTime( date('Y-m-01') );
        $endDate   = $endDate->modify( '+1 month' );

        $processed = $this->PayrollModel->getByRange( $startDate->format('Y-m-d'), $endDate->format('Y-m-d') );

        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod( $startDate, $interval, $endDate );

        foreach( $period as $datetime ) {
            $index = $datetime->format('n');

            $dataID = 'upcoming';
            $statusTab = 'upcoming-tab';
            $status = $this->L10n->getContents( 'LANG_NO_DATA' );

            if( isset( $processed[$index] ) ) {
                $statusTab = 'upcoming-tab';
                $status = $this->L10n->getContents( 'LANG_UPCOMING' );

                if( $processed[$index]['completed'] ) {
                    $dataID = 'complete';
                    $statusTab = 'complete-tab';
                    $status = $this->L10n->getContents( 'LANG_COMPLETED' );
                }
            }
            else if( $index == date('n') ) {
                $dataID = 'pending';
                $statusTab = 'pending-tab active';
                $status = $this->L10n->getContents( 'LANG_PENDING' );
            }

            $vars['dynamic']['tab'][] = array( 'TPLVAR_STATUS_TAB' => $statusTab,
                                               'TPLVAR_MONTH' => $datetime->format('M'),
                                               'TPLVAR_YEAR' => $datetime->format('Y'),
                                               'TPLVAR_STATUS' => $status );

            $vars['dynamic']['tab-pane'][] = array( 'TPLVAR_DATA_ID' => $dataID,
                                                    'TPLVAR_STATUS_TAB' => $statusTab,
                                                    'TPLVAR_LONG_MONTH' => $datetime->format('F'),
                                                    'TPLVAR_MONTH' => $datetime->format('M'),
                                                    'TPLVAR_YEAR' => $datetime->format('Y'),
                                                    'TPLVAR_DATE' => $datetime->format('Y-m-d') );
        }
        $this->setBreadcrumbs( array( 'link' => '',
                                      'icon' => 'icon-stats-bars2',
                                      'text' => $this->L10n->getContents('LANG_PAYROLL_OVERVIEW') ) );

        $this->setJScript( array( 'plugins/forms' => array( 'wizards/stepy.min.js' ) ) );

        $vars = array_merge( $this->L10n->getContents( ), $vars );

        return $this->render( 'markaxis/payroll/overview.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderSlips( ) {
        $this->setBreadcrumbs( array( 'link' => 'admin/payroll/slips',
                                      'icon' => 'icon-cash3',
                                      'text' => $this->L10n->getContents('LANG_MY_PAYSLIPS') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( 'LANG_LINK' => $this->L10n->getContents('LANG_MY_PAYSLIPS') ) );

        return $this->render( 'markaxis/payroll/slips.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderSettings( $form ) {
        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_FORM' => $form ) );

        $this->setBreadcrumbs( array( 'link' => '',
                                      'icon' => 'icon-cog2',
                                      'text' => $this->L10n->getContents('LANG_PAYROLL_SETTINGS') ) );

        return $this->render( 'markaxis/payroll/settings.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderProcess( $processDate ) {
        $OfficeModel = OfficeModel::getInstance( );
        $SelectListView = new SelectListView( );
        $officeList = $SelectListView->build( 'office',
                        $OfficeModel->getList( ), '',
                        '-- Filter by Office / Location --' );

        $vars = array_merge( $this->L10n->getContents( ),
                             array( 'TPLVAR_PROCESS_DATE' => $processDate,
                                    'TPL_OFFICE_LIST' => $officeList ) );

        $this->setBreadcrumbs( array( 'link' => '',
                                      'icon' => 'icon-calculator2',
                                      'text' => $this->L10n->getContents('LANG_PROCESS_PAYROLL') ) );

        return $this->render( 'markaxis/payroll/process.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderProcessForm( $userID, $processDate ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getFieldByUserID( $userID, 'u.fname, u.lname, e.idnumber, e.departmentID,
                                                               e.designationID, e.contractID, e.paymentMethodID,
                                                               DATE_FORMAT(e.startDate, "%D %b %Y") AS startDate, 
                                                               DATE_FORMAT(e.endDate, "%D %b %Y") AS endDate' );

        if( $empInfo ) {
            $UserImageModel = UserImageModel::getInstance( );
            $image = $UserImageModel->getByUserID( $userID, 'up.hashDir, up.hashName' );

            $DepartmentModel = DepartmentModel::getInstance( );
            $dptInfo = $DepartmentModel->getByID( $empInfo['departmentID'] );
            $department = $dptInfo ? $dptInfo['name'] : '';

            $DesignationModel = DesignationModel::getInstance( );
            $dsgInfo = $DesignationModel->getByID( $empInfo['designationID'] );
            $designation = $dsgInfo ? $dsgInfo['title'] : '';

            $ContractModel = ContractModel::getInstance( );
            $conInfo = $ContractModel->getByID( $empInfo['contractID'] );
            $contractType = $conInfo ? $conInfo['type'] : '';

            $PaymentMethodModel = PaymentMethodModel::getInstance( );
            $pmInfo = $PaymentMethodModel->getByID( $empInfo['paymentMethodID'] );
            $method = $pmInfo ? $pmInfo['method'] : '';

            $vars = array( 'TPLVAR_IMAGE' => $image,
                           'TPLVAR_FNAME' => $empInfo['fname'],
                           'TPLVAR_LNAME' => $empInfo['lname'],
                           'TPLVAR_DEPARTMENT' => $department,
                           'TPLVAR_DESIGNATION' => $designation,
                           'TPLVAR_CONTRACT_TYPE' => $contractType,
                           'TPLVAR_IDNUMBER' => $empInfo['idnumber'],
                           'TPLVAR_START_DATE' => $empInfo['startDate'],
                           'TPLVAR_END_DATE' => $empInfo['endDate'] ? $empInfo['endDate'] : ' -- ',
                           'TPLVAR_PAYMENT_METHOD' => $method ? $method : ' -- ' );

            return $this->render( 'markaxis/payroll/processForm.tpl', $vars );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAllByID( $data ) {
        $vars = array( );
        $vars['bool'] = 0;
        $vars['dynamic']['monthly'] = false;

        if( isset( $data['ids'] ) && $info = $this->PayrollModel->getAllByID( $data['ids'] ) ) {
            foreach( $info as $key => $value ) {
                if( isset( $value['name'] ) ) {
                    $vars['dynamic']['monthly'][] = array( 'TPLVAR_IDNUMBER' => $value['idnumber'],
                                                           'TPLVAR_NAME' => $value['name'],
                                                           'TPLVAR_POSITION' => $value['position'] );
                }
            }
        }
        $vars['bool'] = 1;
        $vars['html'] = $this->render( 'markaxis/payroll/selectItem.tpl', $vars );
        return json_encode( $vars );
    }
}
?>