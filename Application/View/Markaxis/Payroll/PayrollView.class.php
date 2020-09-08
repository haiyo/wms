<?php
namespace Markaxis\Payroll;
use \Markaxis\Expense\ExpenseModel, \Markaxis\Company\OfficeModel AS M_OfficeModel;
use \Markaxis\Employee\EmployeeModel, \Aurora\User\UserImageModel;
use \Aurora\Component\OfficeModel AS A_OfficeModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Form\SelectGroupListView;
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
                                                                $datetime->format('Y-m-') . '01',
                                                                $datetime->format('Y-m-') . $lastDay,
                                                                $officeInfo['countryCode'] );

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
                                            'text' => $this->L10n->getContents('LANG_PAYROLL_ARCHIVE') ) );

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
        //TPLVAR_CURRENCY
        $A_OfficeModel = A_OfficeModel::getInstance( );
        $mainInfo = $A_OfficeModel->getMainOffice( );

        $SelectListView = new SelectListView( );
        $officeList = $SelectListView->build( 'office', $A_OfficeModel->getList( ), $mainInfo['oID'],
                                              '-- Filter by Office / Location --' );

        $vars = array_merge( $this->L10n->getContents( ),
                             array( 'TPLVAR_PROCESS_DATE' => $processDate,
                                    'TPLVAR_COUNTRY_CODE' => $mainInfo['countryCode'],
                                    'TPLVAR_CURRENCY' => $mainInfo['currencyCode'] . $mainInfo['currencySymbol'],
                                    'TPL_OFFICE_LIST' => $officeList ) );

        $vars['TPLVAR_COMPLETED'] = $vars['TPLVAR_PID'] = 0;
        $vars['dynamic']['selectEmployee'] = true;
        $vars['dynamic']['accountDetails'] = false;

        if( $payInfo = $this->PayrollModel->getProcessByDate( $processDate ) ) {
            if( $payInfo['completed'] ) {
                $vars['TPLVAR_COMPLETED'] = 1;
                $vars['TPLVAR_PID'] = $payInfo['pID'];
                $vars['dynamic']['selectEmployee'] = false;
                $vars['dynamic']['accountDetails'] = true;
            }
        }

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
    public function renderProcessForm( $userID, $processDate, $data ) {
        $userInfo = $this->PayrollModel->getCalculateUserInfo( $userID );

        if( $userInfo ) {
            $UserImageModel = UserImageModel::getInstance( );

            $vars = array_merge( $this->L10n->getContents( ),
                    array( 'TPLVAR_IMAGE' => $UserImageModel->getImgLinkByUserID( $userID ),
                           'TPLVAR_USERID' => $userID,
                           'TPLVAR_FNAME' => $userInfo['fname'],
                           'TPLVAR_LNAME' => $userInfo['lname'],
                           'TPLVAR_PROCESS_DATE' => $processDate ) );

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

            if( isset( $data['basic'] ) && $data['totalOrdinary'] ) {
                $selected = 'p-' . $data['basic']['piID'];
                $itemType = $SelectGroupListView->build( 'itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

                $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                    'TPLVAR_HIDDEN_ID' => '',
                                                    'TPLVAR_DEDUCTION' => '',
                                                    'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                    'TPLVAR_AMOUNT' => $data['empInfo']['currency'] .
                                                                       number_format( $data['totalOrdinary'],2 ),
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
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => $data['empInfo']['currency'] .
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
                                                                'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                                'TPLVAR_AMOUNT' => $data['empInfo']['currency'] .
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
     * Render summary on first process!
     * @return string
     */
    public function renderProcessSummary( $data, $firstRender=true ) {
        $vars['TPLVAR_GROSS_AMOUNT'] = $vars['TPLVAR_NET_AMOUNT'] = 0;

        if( $firstRender ) {
            $vars['TPLVAR_GROSS_AMOUNT'] = $vars['TPLVAR_NET_AMOUNT'] = $data['totalOrdinary'];
        }

        $vars['TPLVAR_DEDUCTION_AMOUNT'] = $vars['TPLVAR_CLAIM_AMOUNT'] =
        $vars['TPLVAR_FWL_AMOUNT'] = $vars['TPLVAR_SDL_AMOUNT'] =
        $vars['TPLVAR_TOTAL_LEVY'] = $vars['TPLVAR_TOTAL_CONTRIBUTION'] = 0;

        if( isset( $data['gross'] ) ) {
            $vars['TPLVAR_GROSS_AMOUNT'] = (float)$data['gross'];
            $vars['TPLVAR_NET_AMOUNT'] = (float)$data['gross'];

            /*foreach( $data['gross'] as $gross ) {
                if( isset( $gross['amount'] ) ) {
                    $vars['TPLVAR_GROSS_AMOUNT'] += (float)$gross['amount'];
                    $vars['TPLVAR_NET_AMOUNT'] += (float)$gross['amount'];
                }
            }*/
        }
        if( isset( $data['net'] ) ) {
            foreach( $data['net'] as $net ) {
                if( isset( $net['amount'] ) ) {
                    $vars['TPLVAR_NET_AMOUNT'] += (float)$net['amount'];
                }
            }
        }

        $vars['dynamic']['employerItem'] = $vars['dynamic']['deductionSummary'] = false;
        $totalLevy = $totalContribution = 0;
        $itemGroups = array( );

        if( isset( $data['claims'] ) ) {
            $totalClaim = 0;

            foreach( $data['claims'] as $claims ) {
                if( isset( $claims['eiID'] ) ) {
                    $totalClaim += $claims['amount'];
                    $vars['TPLVAR_NET_AMOUNT'] += (float)$claims['amount'];
                }
            }

            $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_CLAIM'),
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $totalClaim,2 ) );
        }

        if( isset( $data['items'] ) && is_array( $data['items'] ) ) {

            foreach( $data['items'] as $item ) {
                if( isset( $item['deductGross'] ) ) {
                    $vars['TPLVAR_GROSS_AMOUNT'] -= (float)$item['amount'];
                }

                $vars['TPLVAR_DEDUCTION_AMOUNT'] += (float)$item['amount'];
                $vars['TPLVAR_NET_AMOUNT'] -= (float)$item['amount'];

                foreach( $data['taxGroups']['mainGroup'] as $key => $taxGroup ) {
                    // First find all the childs in this group and see if we have any summary=1
                    if( isset( $taxGroup['child'] ) ) {
                        $tgIDChilds = array_unique( array_column( $taxGroup['child'],'tgID' ) );

                        if( isset( $item['tgID'] ) && in_array( $item['tgID'], $tgIDChilds ) ) {
                            foreach( $taxGroup['child'] as $childKey => $child ) {
                                if( isset( $child['tgID'] ) && $child['tgID'] == $item['tgID'] ) {
                                    if( $child['summary'] ) {
                                        $itemGroups[$childKey]['title'] = $child['title'];
                                    }
                                    else {
                                        $itemGroups[$childKey]['title'] = $data['taxGroups']['mainGroup'][$child['parent']]['title'];
                                    }

                                    if( isset( $itemGroups[$childKey]['amount'] ) ) {
                                        $itemGroups[$childKey]['amount'] += (float)$item['amount'];
                                    }
                                    else {
                                        $itemGroups[$childKey]['amount'] = (float)$item['amount'];
                                    }
                                    break 2;
                                }
                            }
                        }
                    }
                    else if( isset( $taxGroup['tgID'] ) && isset( $item['tgID'] ) && $taxGroup['tgID'] == $item['tgID'] ) {
                        // If children not found with summary=1, fallback to parent
                        $itemGroups[$key]['title'] = $taxGroup['title'];
                        $itemGroups[$key]['amount'] = (float)$item['amount'];
                        break;
                    }
                }
            }

            foreach( $itemGroups as $groups ) {
                if( isset( $groups['amount'] ) ) {
                    $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $groups['title'],
                                                                    'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                                    'TPLVAR_AMOUNT' => number_format( $groups['amount'],2 ) );
                }
            }
        }

        if( isset( $data['levy'] ) ) {
            foreach( $data['levy'] as $levy ) {
                $totalLevy += $levy['amount'];

                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $levy['title'],
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $levy['amount'],2 ) );
            }

            /*if( $totalLevy ) {
                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_EMPLOYER_LEVY'),
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $totalLevy,2 ) );
            }*/
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
                                                            'TPLVAR_AMOUNT' => number_format( ($totalContribution+$totalLevy),2 ) );
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

        return $this->View->render('markaxis/payroll/processSummary.tpl', array_merge( $this->L10n->getContents( ), $vars ) );
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