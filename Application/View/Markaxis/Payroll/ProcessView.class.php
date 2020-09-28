<?php
namespace Markaxis\Payroll;
use \Markaxis\Expense\ExpenseModel, \Markaxis\Company\OfficeModel AS M_OfficeModel;
use \Markaxis\Employee\EmployeeModel, \Aurora\User\UserImageModel;
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

class ProcessView {


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
    public function renderProcess( $processDate ) {
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
    public function renderProcessForm( $data ) {
        $vars = array_merge( $this->L10n->getContents( ),
            array( 'TPLVAR_IMAGE' => $data['empInfo']['photo'],
                   'TPLVAR_USERID' => $data['empInfo']['userID'],
                   'TPLVAR_NAME' => $data['empInfo']['name'],
                   'TPLVAR_PROCESS_DATE' => $data['payrollInfo']['startDate'] ) );

        $ItemModel = ItemModel::getInstance( );
        $ExpenseModel = ExpenseModel::getInstance( );

        $SelectListView = new SelectListView( );
        $SelectListView->setClass('itemType');

        $fullList = array( );
        $itemList = $ItemModel->getList( );
        $expenseList = $ExpenseModel->getList( );

        $fullList[] = array( 'id' => 1, 'title' => 'Pay Items', 'parent' => 0 );
        foreach( $itemList as $key => $value ) {
            $class = $value['additional'] ? 'additional' : '';
            $fullList[] = array( 'id' => 'p-' . $key, 'title' => $value['title'], 'class' => $class, 'parent' => 1 );
        }

        $fullList[] = array( 'id' => 2, 'title' => 'Expenses', 'parent' => 0 );
        foreach( $expenseList as $key => $value ) {
            $fullList[] = array( 'id' => 'e-' . $key, 'title' => $value , 'parent' => '2' );
        }

        $SelectGroupListView = new SelectGroupListView( );
        $SelectGroupListView->includeBlank(false );
        $SelectGroupListView->setClass("itemType");
        $SelectGroupListView->isDisabled(true );
        $SelectGroupListView->enableSort(false );
        $vars['dynamic']['item'] = $vars['dynamic']['hiddenField'] = false;
        $id = 0;

        if( isset( $data['items']['basic'] ) && $data['items']['totalOrdinary'] ) {
            $selected = 'p-' . $data['items']['basic']['piID'];
            $itemType = $SelectGroupListView->build( 'itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

            $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                'TPLVAR_HIDDEN_ID' => '',
                                                'TPLVAR_DEDUCTION' => '',
                                                'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                'TPLVAR_AMOUNT' => $data['office']['currencyCode'] .
                                                    $data['office']['currencySymbol'] . Money::format( $data['items']['totalOrdinary'] ),
                                                'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                'TPLVAR_REMARK' => '',
                                                'TPLVAR_DISABLED' => 'disabled',
                                                'TPL_ICON' => '' );
            $id++;
        }

        if( isset( $data['itemRow'] ) && is_array( $data['itemRow'] ) ) {
            foreach( $data['itemRow'] as $item ) {
                // We don't want tax groups to show in item list.
                if( !isset( $item['tgID'] ) && isset( $item['piID'] ) /*&&
                        $items['piID'] != $data['deduction']['piID'] &&
                        $items['piID'] != $data['deductionAW']['piID'] */) {

                    $selected  = 'p-' . $item['piID'];
                    $deduction = $hiddenID = '';

                    $SelectGroupListView->isDisabled(false );

                    if( $item['piID'] == $data['items']['deduction']['piID'] || $item['piID'] == $data['items']['deductionAW']['piID'] ) {
                        $deduction = 'deduction';
                    }

                    if( isset( $item['disabled'] ) && $item['disabled'] ) {
                        $SelectGroupListView->isDisabled(true );
                    }

                    $itemType = $SelectGroupListView->build('itemType_' . $id, $fullList, $selected,'Select Payroll Item' );

                    if( isset( $item['hiddenName'] ) ) {
                        $hiddenID = $item['hiddenID'];

                        $vars['dynamic']['hiddenField'][] = array( 'TPLVAR_HIDDEN_NAME' => $item['hiddenName'],
                                                                   'TPLVAR_VALUE' => $item['hiddenValue'],
                                                                   'TPLVAR_HIDDEN_ID' => $item['hiddenID'] );
                    }

                    $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                        'TPLVAR_HIDDEN_ID' => $hiddenID,
                                                        'TPLVAR_DEDUCTION' => $deduction,
                                                        'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                        'TPLVAR_AMOUNT' => $data['office']['currencyCode'] .
                                                                           $data['office']['currencySymbol'] . Money::format( $item['amount'] ),
                                                        'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                        'TPLVAR_REMARK' => $item['remark'],
                                                        'TPLVAR_DISABLED' => '' );
                    $id++;
                }
            }
            if( isset( $data['claims'] ) ) {
                $SelectGroupListView->isDisabled(true );

                foreach( $data['claims'] as $claim ) {
                    if( isset( $claim['eiID'] ) ) {
                        $selected = 'e-' . $claim['eiID'];
                        $itemType = $SelectGroupListView->build('itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

                        $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => $id,
                                                            'TPLVAR_HIDDEN_ID' => 'claim' . $claim['ecID'],
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => $data['office']['currencyCode'] .
                                                                               $data['office']['currencySymbol'] . Money::format( $claim['amount'] ),
                                                            'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                            'TPLVAR_REMARK' => $claim['remark'],
                                                            'TPLVAR_DISABLED' => '' );

                        $vars['dynamic']['hiddenField'][] = array( 'TPLVAR_HIDDEN_ID' => 'claim' . $claim['ecID'],
                                                                   'TPLVAR_HIDDEN_NAME' => 'claim[]',
                                                                   'TPLVAR_VALUE' => $claim['ecID'] );
                        $id++;
                    }
                }
            }
        }
        $SelectGroupListView->isDisabled(false );
        $vars['TPL_PAYROLL_ITEM_LIST'] = $SelectGroupListView->build('itemType_{id}', $fullList, '', 'Select Payroll Item' );
        $vars['TPL_PROCESS_SUMMARY'] = $this->renderProcessSummary( $data );

        if( isset( $data['col_1'] ) ) $vars['TPL_COL_1'] = $data['col_1'];
        if( isset( $data['col_2'] ) ) $vars['TPL_COL_2'] = $data['col_2'];
        if( isset( $data['col_3'] ) ) $vars['TPL_COL_3'] = $data['col_3'];
        return $this->View->render( 'markaxis/payroll/processForm.tpl', $vars );
    }


    /**
     * Render summary on first process!
     * @return string
     */
    public function renderProcessSummary( $data ) {
        $summary = $this->PayrollModel->processSummary( $data );

        /*$vars['TPLVAR_DEDUCTION_AMOUNT'] = $vars['TPLVAR_CLAIM_AMOUNT'] =
        $vars['TPLVAR_FWL_AMOUNT'] = $vars['TPLVAR_SDL_AMOUNT'] =
        $vars['TPLVAR_TOTAL_LEVY'] = $vars['TPLVAR_TOTAL_CONTRIBUTION'] = 0;

        $vars['TPLVAR_GROSS_AMOUNT'] = (float)$data['items']['totalGross'];
        $vars['TPLVAR_NET_AMOUNT'] = (float)$data['items']['totalGross'];

        if( isset( $data['addGross'] ) ) {
            foreach( $data['addGross'] as $addGross ) {
                $vars['TPLVAR_GROSS_AMOUNT'] += (float)$addGross;
                $vars['TPLVAR_NET_AMOUNT'] += (float)$addGross;
            }
        }

        if( isset( $data['deductGross'] ) ) {
            foreach( $data['deductGross'] as $addGross ) {
                $vars['TPLVAR_GROSS_AMOUNT'] -= (float)$addGross;
                $vars['TPLVAR_NET_AMOUNT'] -= (float)$addGross;
            }
        }

        $vars['dynamic']['employerItem'] = $vars['dynamic']['deductionSummary'] = false;
        $itemGroups = array( );*/

        $totalClaim = 0;

        if( isset( $data['claims'] ) ) {

            foreach( $data['claims'] as $claims ) {
                if( isset( $claims['eiID'] ) ) {
                    $totalClaim += $claims['amount'];
                    //$vars['TPLVAR_NET_AMOUNT'] += (float)$claims['amount'];
                }
            }

            if( $totalClaim > 0 ) {
                $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_CLAIM'),
                                                                'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                                'TPLVAR_AMOUNT' => Money::format( $totalClaim ),
                                                                'TPLVAR_SHOW_TIP' => 'hide',
                                                                'TPLVAR_REMARK' => '' );
            }
        }

        if( isset( $summary['itemGroups'] ) ) {
            foreach( $summary['itemGroups'] as $groups ) {
                if( isset( $groups['amount'] ) ) {
                    $showTips = 'hide';
                    $remark = '';

                    if( $groups['remark'] ) {
                        $showTips = '';
                        $remark = $groups['remark'];
                    }

                    $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $groups['title'],
                                                                    'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                                    'TPLVAR_AMOUNT' => Money::format( $groups['amount'] ),
                                                                    'TPLVAR_SHOW_TIP' => $showTips,
                                                                    'TPLVAR_REMARK' => $remark );
                }
            }
        }

        $totalLevy = 0;

        if( isset( $data['levy'] ) ) {
            foreach( $data['levy'] as $levy ) {
                $totalLevy += $levy['amount'];

                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $levy['title'],
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => Money::format( $levy['amount'] ),
                                                            'TPLVAR_SHOW_TIP' => 'hide',
                                                            'TPLVAR_REMARK' => '' );
            }

            /*if( $totalLevy ) {
                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_EMPLOYER_LEVY'),
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $totalLevy,2 ) );
            }*/
        }

        $totalContribution = 0;

        if( isset( $data['contribution'] ) && is_array( $data['contribution'] ) ) {
            foreach( $data['contribution'] as $contribution ) {
                $totalContribution += $contribution['amount'];

                $showTips = 'hide';
                $remark = '';

                if( $contribution['remark'] ) {
                    $showTips = '';
                    $remark = $contribution['remark'];
                }

                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $contribution['title'],
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => Money::format( $contribution['amount'] ),
                                                            'TPLVAR_SHOW_TIP' => $showTips,
                                                            'TPLVAR_REMARK' => $remark );
            }
            if( $totalContribution ) {
                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_EMPLOYER_CONTRIBUTION'),
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => Money::format( ($totalContribution+$totalLevy) ),
                                                            'TPLVAR_SHOW_TIP' => 'hide' );
            }
        }

        $vars['TPLVAR_CURRENCY'] = $data['empInfo']['currency'];
        $vars['TPLVAR_GROSS_AMOUNT'] = Money::format( $summary['gross'] );
        $vars['TPLVAR_CLAIM_AMOUNT'] = Money::format( $summary['claim'] );
        $vars['TPLVAR_DEDUCTION_AMOUNT'] = Money::format( $summary['deduction'] );
        $vars['TPLVAR_NET_AMOUNT'] = Money::format( $summary['net'] );
        $vars['TPLVAR_TOTAL_CONTRIBUTION'] = Money::format( $summary['contribution'] );
        $vars['TPLVAR_SDL_AMOUNT'] = Money::format( $summary['sdl'] );
        $vars['TPLVAR_FWL_AMOUNT'] = Money::format( $summary['fwl'] );

        return $this->View->render('markaxis/payroll/processSummary.tpl', array_merge( $this->L10n->getContents( ), $vars ) );
    }
}
?>