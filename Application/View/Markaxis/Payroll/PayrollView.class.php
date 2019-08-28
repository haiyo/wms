<?php
namespace Markaxis\Payroll;
use \Markaxis\Expense\ExpenseModel, \Markaxis\Company\OfficeModel AS M_OfficeModel;
use \Markaxis\Employee\EmployeeModel, \Aurora\User\UserImageModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Form\SelectGroupListView, \Aurora\Component\OfficeModel;
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

        $OfficeModel = M_OfficeModel::getInstance( );
        $EmployeeModel = EmployeeModel::getInstance( );

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
            $workDays  = $OfficeModel->getWorkingDaysByRange( $datetime->format('Y-m-') . '01',
                                                              $datetime->format('Y-m-') . $lastDay );

            if( isset( $processed[$index]['completed'] ) && $processed[$index]['completed'] ) {
                $dataID    = 'complete';
                $statusTab = 'complete-tab';
                $pane      = 'tab-pane';
                $status    = $this->L10n->getContents('LANG_COMPLETED');
            }
            else if( $index == date('n') ) {
                $dataID    = 'pending';
                $statusTab = 'pending-tab active show';
                $status    = $this->L10n->getContents('LANG_PENDING');
            }

            $vars['dynamic']['tab'][] = array( 'TPLVAR_STATUS_TAB' => $statusTab,
                                               'TPLVAR_MONTH' => $month,
                                               'TPLVAR_YEAR' => $year,
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
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-stats-bars2',
                                            'text' => $this->L10n->getContents('LANG_PAYROLL_OVERVIEW') ) );

        $this->View->setJScript( array( 'plugins/forms' => array( 'wizards/stepy.min.js' ) ) );
        $vars = array_merge( $this->L10n->getContents( ), $vars );
        $this->View->printAll( $this->View->render( 'markaxis/payroll/overview.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSlips( ) {
        $this->View->setBreadcrumbs( array( 'link' => 'admin/payroll/slips',
                                            'icon' => 'icon-cash3',
                                            'text' => $this->L10n->getContents('LANG_MY_PAYSLIPS') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( 'LANG_LINK' => $this->L10n->getContents('LANG_MY_PAYSLIPS') ) );

        return $this->View->render( 'markaxis/payroll/slips.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( $form ) {
        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_FORM' => $form ) );

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
        $OfficeModel = OfficeModel::getInstance( );
        $SelectListView = new SelectListView( );
        $officeList = $SelectListView->build( 'office', $OfficeModel->getList( ), '',
                                              '-- Filter by Office / Location --' );

        $vars = array_merge( $this->L10n->getContents( ),
                             array( 'TPLVAR_PROCESS_DATE' => $processDate,
                                    'TPL_OFFICE_LIST' => $officeList ) );

        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-calculator2',
                                            'text' => $this->L10n->getContents('LANG_PROCESS_PAYROLL') ) );

        return $this->View->printAll( $this->View->render( 'markaxis/payroll/process.tpl', $vars ) );
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
                           'TPLVAR_USERID' => $userID,
                           'TPLVAR_FNAME' => $userInfo['fname'],
                           'TPLVAR_LNAME' => $userInfo['lname'],
                           'TPLVAR_PROCESS_DATE' => $processDate );

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
            $vars['dynamic']['item'] = $vars['dynamic']['hiddenField'] = false;
            $id = 0;

            if( isset( $data['basic'] ) && $data['empInfo']['salary'] ) {
                $selected = 'p-' . $data['basic']['piID'];
                $itemType = $SelectGroupListView->build( 'itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

                $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                    'TPLVAR_HIDDEN_ID' => '',
                                                    'TPLVAR_DEDUCTION' => '',
                                                    'TPLVAR_CURRENCY' => $userInfo['currency'],
                                                    'TPLVAR_AMOUNT' => $userInfo['currency'] .
                                                                       number_format( $data['empInfo']['salary'],2 ),
                                                    'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                    'TPLVAR_REMARK' => '',
                                                    'TPL_ICON' => '' );
                $id++;
            }
            if( isset( $data['items'] ) && is_array( $data['items'] ) ) {
                foreach( $data['items'] as $item ) {
                    // We don't want tax groups to show in item list.
                    if( !isset( $item['tgID'] ) && isset( $item['piID'] ) /*&&
                        $items['piID'] != $data['deduction']['piID'] &&
                        $items['piID'] != $data['deductionAW']['piID'] */) {

                        $selected  = 'p-' . $item['piID'];
                        $deduction = $hiddenID = '';

                        if( $item['piID'] == $data['deduction']['piID'] || $item['piID'] == $data['deductionAW']['piID'] ) {
                            $deduction = 'deduction';
                        }
                        $itemType = $SelectGroupListView->build('itemType_' . $id, $fullList, $selected,
                                                                'Select Payroll Item' );

                        if( isset( $item['hiddenName'] ) ) {
                            $hiddenID = $item['hiddenID'];

                            $vars['dynamic']['hiddenField'][] = array( 'TPLVAR_HIDDEN_NAME' => $item['hiddenName'],
                                                                       'TPLVAR_VALUE' => $item['hiddenValue'],
                                                                       'TPLVAR_HIDDEN_ID' => $item['hiddenID'] );
                        }

                        $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                            'TPLVAR_HIDDEN_ID' => $hiddenID,
                                                            'TPLVAR_DEDUCTION' => $deduction,
                                                            'TPLVAR_AMOUNT' => $userInfo['currency'] .
                                                                                number_format( $item['amount'],2 ),
                                                            'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                            'TPLVAR_REMARK' => $item['remark'] );
                        $id++;
                    }
                }
                if( isset( $data['claims'] ) ) {
                    foreach( $data['claims'] as $claim ) {
                        if( isset( $claim['eiID'] ) ) {
                            $selected = 'e-' . $claim['eiID'];
                            $itemType = $SelectGroupListView->build('itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

                            $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                                'TPLVAR_HIDDEN_ID' => 'claim' . $claim['ecID'],
                                                                'TPLVAR_AMOUNT' => $userInfo['currency'] .
                                                                                   number_format( $claim['amount'],2 ),
                                                                'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                                'TPLVAR_REMARK' => $claim['remark'] );

                            $vars['dynamic']['hiddenField'][] = array( 'TPLVAR_HIDDEN_ID' => 'claim' . $claim['ecID'],
                                                                       'TPLVAR_HIDDEN_NAME' => 'claim[]',
                                                                       'TPLVAR_VALUE' => $claim['ecID'] );
                            $id++;
                        }
                    }
                }
            }
            $vars['TPL_PAYROLL_ITEM_LIST'] = $SelectGroupListView->build('itemType_{id}', $fullList, '', 'Select Payroll Item' );
            $vars['TPL_PROCESS_SUMMARY'] = $this->renderProcessSummary( $data );

            if( isset( $data['col_1'] ) ) $vars['TPL_COL_1'] = $data['col_1'];
            if( isset( $data['col_2'] ) ) $vars['TPL_COL_2'] = $data['col_2'];
            if( isset( $data['col_3'] ) ) $vars['TPL_COL_3'] = $data['col_3'];
            return $this->View->render( 'markaxis/payroll/processForm.tpl', $vars );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderProcessSummary( $data ) {
        $vars['TPLVAR_GROSS_AMOUNT'] = $vars['TPLVAR_DEDUCTION_AMOUNT'] =
        $vars['TPLVAR_NET_AMOUNT'] = $vars['TPLVAR_CLAIM_AMOUNT'] =
        $vars['TPLVAR_FWL_AMOUNT'] = $vars['TPLVAR_SDL_AMOUNT'] =
        $vars['TPLVAR_TOTAL_LEVY'] = $vars['TPLVAR_TOTAL_CONTRIBUTION'] = 0;

        if( isset( $data['gross'] ) ) {
            foreach( $data['gross'] as $gross ) {
                if( isset( $gross['amount'] ) ) {
                    $vars['TPLVAR_GROSS_AMOUNT'] += (float)$gross['amount'];
                    $vars['TPLVAR_NET_AMOUNT'] += (float)$gross['amount'];
                }
            }
        }
        if( isset( $data['net'] ) ) {
            foreach( $data['net'] as $net ) {
                if( isset( $net['amount'] ) ) {
                    $vars['TPLVAR_NET_AMOUNT'] += (float)$net['amount'];
                }
            }
        }

        $vars['dynamic']['employerItem'] = $vars['dynamic']['deductionSummary'] = false;
        $totalLevy = $totalContribution = $totalClaim = 0;
        $itemGroups = array( );

        if( isset( $data['claims'] ) ) {
            foreach( $data['claims'] as $claims ) {
                if( isset( $claims['eiID'] ) ) {
                    $totalClaim += $claims['amount'];
                    $vars['TPLVAR_NET_AMOUNT'] += (float)$claims['amount'];
                }
            }
        }

        $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_CLAIM'),
                                                        'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                        'TPLVAR_AMOUNT' => number_format( $totalClaim,2 ) );

        if( isset( $data['items'] ) && is_array( $data['items'] ) ) {
            foreach( $data['items'] as $items ) {
                if( isset( $data['deduction'] ) ) {
                    $vars['TPLVAR_DEDUCTION_AMOUNT'] += (float)$items['amount'];
                    $vars['TPLVAR_NET_AMOUNT'] -= (float)$items['amount'];

                    foreach( $data['taxGroups']['mainGroup'] as $key => $taxGroups ) {
                        if( $taxGroups['summary'] ) {
                            if( isset( $items['tgID'] ) && in_array( $items['tgID'], $taxGroups['child'] ) ) {

                                $itemGroups[$key]['title'] = $taxGroups['title'];

                                if( isset( $itemGroups[$key]['amount'] ) ) {
                                    $itemGroups[$key]['amount'] += (float)$items['amount'];
                                }
                                else {
                                    $itemGroups[$key]['amount'] = (float)$items['amount'];
                                }
                            }
                        }
                    }
                }
            }
            foreach( $itemGroups as $groups ) {
                $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $groups['title'],
                                                                'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                                'TPLVAR_AMOUNT' => number_format( $groups['amount'],2 ) );
            }
        }

        if( isset( $data['levy'] ) ) {
            foreach( $data['levy'] as $levy ) {
                $totalLevy += $levy['amount'];

                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $levy['title'],
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $levy['amount'],2 ) );
            }

            if( $totalLevy ) {
                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_EMPLOYER_LEVY'),
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $totalLevy,2 ) );
            }
        }

        if( isset( $data['contribution'] ) && is_array( $data['contribution'] ) ) {
            foreach( $data['contribution'] as $contribution ) {
                $totalContribution += $contribution['amount'];

                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $contribution['title'],
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $contribution['amount'],2 ) );
            }
            if( $totalContribution ) {
                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_EMPLOYER_CONTRIBUTION'),
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $totalContribution,2 ) );
            }
        }

        $vars['TPLVAR_CURRENCY'] = $data['empInfo']['currency'];
        $vars['TPLVAR_GROSS_AMOUNT'] = number_format( $vars['TPLVAR_GROSS_AMOUNT'],2 );
        $vars['TPLVAR_CLAIM_AMOUNT'] = number_format( $vars['TPLVAR_CLAIM_AMOUNT'],2 );
        $vars['TPLVAR_DEDUCTION_AMOUNT'] = number_format( $vars['TPLVAR_DEDUCTION_AMOUNT'],2 );
        $vars['TPLVAR_NET_AMOUNT'] = number_format( $vars['TPLVAR_NET_AMOUNT'],2 );
        $vars['TPLVAR_TOTAL_CONTRIBUTION'] = number_format( $vars['TPLVAR_TOTAL_CONTRIBUTION'],2 );
        $vars['TPLVAR_SDL_AMOUNT'] = number_format( $vars['TPLVAR_SDL_AMOUNT'],2 );
        $vars['TPLVAR_FWL_AMOUNT'] = number_format( $vars['TPLVAR_FWL_AMOUNT'],2 );

        return $this->View->render('markaxis/payroll/processSummary.tpl', $vars );
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