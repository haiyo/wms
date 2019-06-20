<?php
namespace Markaxis\Payroll;
use \Markaxis\Expense\ExpenseModel;
use \Aurora\User\UserImageModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Form\SelectGroupListView, \Aurora\Component\OfficeModel;
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
                                  'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js',
                                                            'input/typeahead.bundle.min.js' ),
                                  'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                  'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js', 'widgets.min.js' ) ) );
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

        foreach( $period as $datetime ) {
            $index = $datetime->format('n');

            $dataID = 'upcoming';
            $pane = 'tab-pane-process';
            $statusTab = 'upcoming-tab';
            $status = $this->L10n->getContents( 'LANG_NO_DATA' );

            if( isset( $processed[$index]['completed'] ) && $processed[$index]['completed'] ) {
                $dataID = 'complete';
                $statusTab = 'complete-tab';
                $pane = 'tab-pane';
                $status = $this->L10n->getContents( 'LANG_COMPLETED' );
            }
            else if( $index == date('n') ) {
                $dataID = 'pending';
                $statusTab = 'pending-tab active show';
                $status = $this->L10n->getContents( 'LANG_PENDING' );
            }

            $vars['dynamic']['tab'][] = array( 'TPLVAR_STATUS_TAB' => $statusTab,
                                               'TPLVAR_MONTH' => $datetime->format('M'),
                                               'TPLVAR_YEAR' => $datetime->format('Y'),
                                               'TPLVAR_STATUS' => $status );

            $vars['dynamic'][$pane][] = array( 'TPLVAR_DATA_ID' => $dataID,
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
     * @return string
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
     * @return string
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
     * @return string
     */
    public function renderProcess( $processDate ) {
        $OfficeModel = OfficeModel::getInstance( );
        $SelectListView = new SelectListView( );
        $officeList = $SelectListView->build( 'office', $OfficeModel->getList( ), '',
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
     * @return string
     */
    public function renderProcessForm( $userID, $processDate, $data ) {
        $userInfo = $this->PayrollModel->getCalculateUserInfo( $userID );

        if( $userInfo ) {
            $UserImageModel = UserImageModel::getInstance( );

            $vars = array( 'TPLVAR_IMAGE' => $UserImageModel->getImgLinkByUserID( $userID ),
                           'TPLVAR_USERID' => $userID );

            /*$vars = array( 'TPLVAR_IMAGE' => $UserImageModel->getByUserID( $userID, 'up.hashDir, up.hashName' ),
                           'TPLVAR_FNAME' => $userInfo['fname'],
                           'TPLVAR_LNAME' => $userInfo['lname'],
                           'TPLVAR_AGE' => $userInfo['birthday'] ? Date::getAge( $userInfo['birthday'] ) : ' -- ',
                           'TPLVAR_DEPARTMENT' => $userInfo['department'] ? $userInfo['department'] : ' -- ',
                           'TPLVAR_DESIGNATION' => $userInfo['designation'] ? $userInfo['designation'] : ' -- ',
                           'TPLVAR_CONTRACT_TYPE' => $userInfo['contractType'] ? $userInfo['contractType'] : ' -- ',
                           'TPLVAR_WORK_PASS' => $userInfo['passType'] ? $userInfo['passType'] : $userInfo['nationality'],
                           'TPLVAR_IDNUMBER' => $userInfo['idnumber'],
                           'TPLVAR_START_DATE' => $userInfo['startDate'],
                           'TPLVAR_END_DATE' => $userInfo['endDate'] ? $userInfo['endDate'] : ' -- ',
                           'TPLVAR_CONFIRM_DATE' => $userInfo['confirmDate'] ? $userInfo['confirmDate'] : ' -- ',
                           'TPLVAR_DURATION_YEAR' => $duration->y,
                           'TPLVAR_DURATION_MONTH' => $duration->m,
                           'TPLVAR_CURRENCY' => $userInfo['currency'],
                           'TPLVAR_PAYMENT_METHOD' => $userInfo['paymentMethod'] ? $userInfo['paymentMethod'] : ' -- ',
                           'TPLVAR_BANK_NAME' => $userInfo['bankName'] ? $userInfo['bankName'] : ' -- ',
                           'TPLVAR_BANK_NUMBER' => $userInfo['number'] ? $userInfo['number'] : ' -- ',
                           'TPLVAR_BANK_CODE' => $userInfo['code'] ? $userInfo['code'] : ' -- ',
                           'TPLVAR_BRANCH_CODE' => $userInfo['branchCode'] ? $userInfo['branchCode'] : ' -- ',
                           'TPLVAR_BANK_SWIFT_CODE' => $userInfo['swiftCode'] ? $userInfo['swiftCode'] : ' -- ' );*/

            $ItemModel = ItemModel::getInstance( );
            $ExpenseModel = ExpenseModel::getInstance( );

            $SelectListView = new SelectListView( );
            $SelectListView->setClass('itemType');

            $fullList = array( );
            $itemList = $ItemModel->getList( );
            $expenseList = $ExpenseModel->getList( );

            $fullList[] = array( 'id' => 1, 'title' => 'Pay Items', 'parent' => 0 );
            foreach( $itemList as $key => $value ) {
                $fullList[] = array( 'id' => 'p-' . $key, 'title' => $value, 'parent' => 1 );
            }

            $fullList[] = array( 'id' => 2, 'title' => 'Expenses', 'parent' => 0 );
            foreach( $expenseList as $key => $value ) {
                $fullList[] = array( 'id' => 'e-' . $key, 'title' => $value, 'parent' => '2' );
            }

            $SelectGroupListView = new SelectGroupListView( );
            $SelectGroupListView->includeBlank(false );
            $SelectGroupListView->setClass("itemType");

            $vars['dynamic']['item'] = false;
            $id = 0;

            if( isset( $data['basic'] ) && $data['empInfo']['salary'] ) {
                $selected = 'p-' . $data['basic']['piID'];
                $itemType = $SelectGroupListView->build( 'itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

                $vars['TPLVAR_GROSS_AMOUNT'] = number_format( $data['empInfo']['salary'] );
                $vars['TPLVAR_NET_AMOUNT'] = $data['empInfo']['salary'];

                $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                    'TPLVAR_CURRENCY' => $userInfo['currency'],
                                                    'TPLVAR_AMOUNT' => $userInfo['currency'] . $vars['TPLVAR_GROSS_AMOUNT'],
                                                    'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                    'TPLVAR_REMARK' => '',
                                                    'TPL_ICON' => '' );
                $id++;
            }

            if( isset( $data['items'] ) && is_array( $data['items'] ) ) {
                $vars['TPLVAR_GROSS_AMOUNT'] = $vars['TPLVAR_DEDUCTION_AMOUNT'] =
                $vars['TPLVAR_NET_AMOUNT'] = $vars['TPLVAR_CLAIM_AMOUNT'] = 0;

                if( isset( $data['items'] ) ) {
                    foreach( $data['items'] as $items ) {
                        if( isset( $items['piID'] ) ) {
                            $selected = 'p-' . $items['piID'];

                            if( isset( $data['deduction'] ) ) {
                                $vars['TPLVAR_DEDUCTION_AMOUNT'] += (float)$items['amount'];
                                $vars['TPLVAR_NET_AMOUNT'] -= (float)$items['amount'];
                            }
                        }
                        $itemType = $SelectGroupListView->build('itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

                        $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                            'TPLVAR_AMOUNT' => $userInfo['currency'] . number_format( $items['amount'] ),
                                                            'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                            'TPLVAR_REMARK' => $items['title'] );
                        $id++;
                    }
                }

                if( isset( $data['claims'] ) ) {
                    foreach( $data['claims'] as $claims ) {
                        if( isset( $claims['eiID'] ) ) {
                            $selected = 'e-' . $claims['eiID'];

                            $vars['TPLVAR_CLAIM_AMOUNT'] += (float)$claims['amount'];
                            $vars['TPLVAR_NET_AMOUNT'] += (float)$claims['amount'];

                            $itemType = $SelectGroupListView->build('itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

                            $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                                'TPLVAR_AMOUNT' => $userInfo['currency'] . number_format( $claims['amount'] ),
                                                                'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                                'TPLVAR_REMARK' => $claims['title'] );
                            $id++;
                        }
                    }
                }
                $vars['TPL_PAYROLL_ITEM_LIST'] = $SelectGroupListView->build('itemType_{id}', $fullList, '', 'Select Payroll Item' );
                $vars['TPLVAR_CLAIM_AMOUNT'] = number_format( $vars['TPLVAR_CLAIM_AMOUNT'] );
                $vars['TPLVAR_DEDUCTION_AMOUNT'] = number_format( $vars['TPLVAR_DEDUCTION_AMOUNT'] );
                $vars['TPLVAR_NET_AMOUNT'] = number_format( $vars['TPLVAR_NET_AMOUNT'] );
            }

            if( isset( $data['col_1'] ) ) $vars['TPL_COL_1'] = $data['col_1'];
            if( isset( $data['col_2'] ) ) $vars['TPL_COL_2'] = $data['col_2'];
            if( isset( $data['col_3'] ) ) $vars['TPL_COL_3'] = $data['col_3'];
            return $this->render( 'markaxis/payroll/processForm.tpl', $vars );
        }
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
        $vars['html'] = $this->render( 'markaxis/payroll/selectItem.tpl', $vars );
        return json_encode( $vars );
    }
}
?>