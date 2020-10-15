<?php
namespace Markaxis\Payroll;
use \Markaxis\Expense\ExpenseModel, \Markaxis\Company\OfficeModel AS M_OfficeModel;
use \Markaxis\Employee\EmployeeModel;
use \Aurora\Component\OfficeModel AS A_OfficeModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Form\SelectGroupListView;
use \Library\Util\Money;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PayrollView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollView {


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
        $this->View = AdminView::getInstance( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->PayrollModel = PayrollModel::getInstance( );

        $this->View->setJScript( array( 'plugins/visualization' => 'echarts/echarts.min.js',
                                        'plugins/moment' => 'moment.min.js',
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                        'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js',
                                                                  'input/typeahead.bundle.min.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ),
                                        'locale' => $this->L10n->getL10n( ) ) );
    }


    /**
     * Render main navigation
     * @return string
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

        $A_OfficeModel = A_OfficeModel::getInstance( );
        $M_OfficeModel = M_OfficeModel::getInstance( );
        $EmployeeModel = EmployeeModel::getInstance( );

        $officeInfo = $A_OfficeModel->getMainOffice( );

        $vars['dynamic']['tab-pane-process'] = $vars['dynamic']['tab-pane'] = false;

        foreach( $period as $datetime ) {
            $index     = $datetime->format('n') . $datetime->format('Y');
            $dataID    = 'upcoming';
            $pane      = 'tab-pane-process';
            $statusTab = 'upcoming-tab';
            $status    = $this->L10n->getContents('LANG_NO_DATA');
            $month     = $datetime->format('M');
            $year      = $datetime->format('Y');
            $lastDay   = $datetime->format('t');
            $ymd       = $datetime->format('Y-m-d');
            $workDays  = $M_OfficeModel->getWorkingDaysByRange( $officeInfo['oID'],
                                                                new \DateTime( $datetime->format('Y-m-01') ),
                                                                new \DateTime($datetime->format('Y-m-') . $lastDay . ' 23:59:59' ) );

            if( isset( $processed[$index]['completed'] ) && $processed[$index]['completed'] ) {
                $dataID    = 'complete';
                $statusTab = 'complete-tab';
                $pane      = 'tab-pane';
                $status    = $this->View->getGlobalRes( )->getContents('LANG_COMPLETED');
            }
            else if( $index == date('nY') ) {
                $dataID    = 'pending';
                $statusTab = 'pending-tab active show';
                $status    = $this->View->getGlobalRes( )->getContents('LANG_PENDING');
            }

            $vars['dynamic']['tab'][] = array( 'TPLVAR_STATUS_TAB' => $statusTab,
                                               'TPLVAR_MONTH' => $month,
                                               'TPLVAR_YEAR' => $year,
                                               'TPLVAR_DATA_DATE' => $ymd,
                                               'TPLVAR_STATUS' => $status );

            $vars['dynamic'][$pane][] = array( 'TPLVAR_DATA_ID' => $dataID,
                                               'TPLVAR_STATUS_TAB' => $statusTab,
                                               'TPLVAR_WORK_DAYS' => $workDays,
                                               'TPLVAR_LONG_MONTH' => $datetime->format('F'),
                                               'TPLVAR_LAST_DAY' => $lastDay,
                                               'TPLVAR_EMPLOYEE_COUNT' => $EmployeeModel->getCountByDate( $ymd ),
                                               'TPLVAR_MONTH' => $month,
                                               'TPLVAR_YEAR' => $year,
                                               'TPLVAR_DATE' => $ymd );
        }

        $this->View->setHeaderLinks( array( 'link' => '#',
                                            'classname' => 'payroll-archive',
                                            'icon' => 'icon-calendar22',
                                            'toggle' => '',
                                            'target' => '',
                                            'text' => $this->L10n->getContents('LANG_PAYROLL_ARCHIVE') ) );

        $this->View->setTitle( $this->L10n->getContents('LANG_PAYROLL_OVERVIEW') );
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-stats-bars2',
                                            'text' => $this->L10n->getContents('LANG_PAYROLL_OVERVIEW') ) );

        $this->View->setJScript( array( 'plugins/pickers' => array( 'picker.js', 'picker.date.js' ),
                                        'markaxis' => array( 'pickerExtend.js', 'payrollOverview.js' ) ) );

        $vars = array_merge( $this->L10n->getContents( ), $vars );
        $this->View->printAll( $this->View->render( 'markaxis/payroll/overview.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( $form ) {
        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_FORM' => $form ) );

        $this->View->setTitle( $this->L10n->getContents('LANG_PAYROLL_SETTINGS') );
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-cog2',
                                            'text' => $this->L10n->getContents('LANG_PAYROLL_SETTINGS') ) );

        $this->View->printAll( $this->View->render( 'markaxis/payroll/settings.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderProcess( $processDate ) {
        $A_OfficeModel = A_OfficeModel::getInstance( );
        $mainInfo = $A_OfficeModel->getMainOffice( );

        $SelectListView = new SelectListView( );
        $officeList = $SelectListView->build( 'office', $A_OfficeModel->getList( ), $mainInfo['oID'],
                                              '-- ' . $this->L10n->getContents('LANG_FILTER_OFFICE_LOCATION') . ' --' );

        $vars = array_merge( $this->L10n->getContents( ),
                             array( 'TPLVAR_PROCESS_DATE' => $processDate,
                                    'TPLVAR_COUNTRY_CODE' => $mainInfo['countryCode'],
                                    'TPLVAR_CURRENCY' => $mainInfo['currencyCode'] . $mainInfo['currencySymbol'],
                                    'TPL_OFFICE_LIST' => $officeList ) );

        $vars['TPLVAR_COMPLETED'] = $vars['TPLVAR_PID'] = 0;
        $vars['dynamic']['selectEmployee'] = true;
        $vars['dynamic']['accountDetails'] = false;

        if( $payInfo = $this->PayrollModel->getProcessByDate( $processDate ) ) {
            $vars['TPLVAR_PID'] = $payInfo['pID'];

            if( $payInfo['completed'] ) {
                $vars['TPLVAR_COMPLETED'] = 1;
                $vars['dynamic']['selectEmployee'] = false;
                $vars['dynamic']['accountDetails'] = true;
            }
        }
        else {
            // Create payroll
            $vars['TPLVAR_PID'] = $this->PayrollModel->createPayroll( $processDate );

        }

        $this->View->setTitle( $this->L10n->getContents('LANG_PROCESS_PAYROLL') );
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-calculator2',
                                            'text' => $this->L10n->getContents('LANG_PROCESS_PAYROLL') ) );

        $this->View->setJScript( array( 'markaxis' => array( 'payrollEmployee.js', 'payrollProcessed.js', 'payrollFinalized.js' ) ) );

        return $this->View->printAll( $this->View->render( 'markaxis/payroll/process.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAllByID( $data ) {
        $vars = array( );
        $vars['bool'] = 0;
        $vars['dynamic']['monthly'] = false;

        if( isset( $data['ids'] ) && $info = $this->PayrollModel->getAllByID( $data['ids'] ) ) {
            foreach( $info as $value ) {
                if( isset( $value['name'] ) ) {
                    $vars['dynamic']['monthly'][] = array( 'TPLVAR_IDNUMBER' => $value['idnumber'],
                                                           'TPLVAR_NAME' => $value['name'],
                                                           'TPLVAR_POSITION' => $value['position'] );
                }
            }
        }
        $vars['bool'] = 1;
        $vars['html'] = $this->View->render( 'markaxis/payroll/selectItem.tpl', $vars );
        return json_encode( $vars );
    }
}
?>