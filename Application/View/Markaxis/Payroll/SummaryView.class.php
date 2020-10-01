<?php
namespace Markaxis\Payroll;
use \Markaxis\Expense\ExpenseModel;
use \Aurora\Admin\AdminView;
use \Aurora\Form\SelectListView, \Aurora\Form\SelectGroupListView;
use \Library\Util\Money;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: SummaryView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SummaryView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $SummaryModel;


    /**
    * SummaryView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->SummaryModel = SummaryModel::getInstance( );
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
        //$SelectGroupListView->isDisabled(true );
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

                    //$SelectGroupListView->isDisabled(false );

                    if( $item['piID'] == $data['items']['deduction']['piID'] || $item['piID'] == $data['items']['deductionAW']['piID'] ) {
                        $deduction = 'deduction';
                    }

                    /*if( ( isset( $item['disabled'] ) && $item['disabled'] ) || isset( $data['payrollUser']['puID'] ) ) {
                        $SelectGroupListView->isDisabled(true );
                    }*/

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
                                                        'TPLVAR_REMARK' => $item['remark'] );
                    $id++;
                }
            }
        }

        if( isset( $data['claims'] ) ) {
            //$SelectGroupListView->isDisabled(true );

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
                                                        'TPLVAR_REMARK' => $claim['remark'] );

                    $vars['dynamic']['hiddenField'][] = array( 'TPLVAR_HIDDEN_ID' => 'claim' . $claim['ecID'],
                                                               'TPLVAR_HIDDEN_NAME' => 'claim[]',
                                                               'TPLVAR_VALUE' => $claim['ecID'] );
                    $id++;
                }
            }
        }

        //$SelectGroupListView->isDisabled(false );
        $vars['TPL_PAYROLL_ITEM_LIST'] = $SelectGroupListView->build('itemType_{id}', $fullList, '', 'Select Payroll Item' );
        $vars['TPL_ITEM_LIST'] = $this->View->render( 'markaxis/payroll/itemInput.tpl', $vars );
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
        $summary = $this->SummaryModel->processSummary( $data );

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

        if( isset( $data['levies'] ) ) {
            foreach( $data['levies'] as $levy ) {
                $totalLevy += $levy['amount'];

                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $levy['title'],
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => Money::format( $levy['amount'] ),
                                                            'TPLVAR_SHOW_TIP' => 'hide',
                                                            'TPLVAR_REMARK' => '' );
            }
        }

        $totalContribution = 0;

        if( isset( $data['contributions'] ) && is_array( $data['contributions'] ) ) {
            foreach( $data['contributions'] as $contribution ) {
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

        $totalClaim = 0;

        if( isset( $data['claims'] ) ) {
            foreach( $data['claims'] as $claims ) {
                if( isset( $claims['eiID'] ) ) {
                    $totalClaim += $claims['amount'];
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

        $vars['TPLVAR_CURRENCY'] = $data['office']['currencyCode'] . $data['office']['currencySymbol'];
        $vars['TPLVAR_GROSS_AMOUNT'] = Money::format( $summary['gross'] );
        $vars['TPLVAR_NET_AMOUNT'] = Money::format( $summary['net'] );

        return $this->View->render('markaxis/payroll/processSummary.tpl', array_merge( $this->L10n->getContents( ), $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSavedForm( $data ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_IMAGE' => $data['empInfo']['photo'],
                       'TPLVAR_USERID' => $data['empInfo']['userID'],
                       'TPLVAR_NAME' => $data['empInfo']['name'],
                       'TPLVAR_PROCESS_DATE' => $data['payrollInfo']['startDate'] ) );

        $SelectListView = new SelectListView( );
        $SelectListView->setClass('itemType');

        $ItemModel = ItemModel::getInstance( );
        $ExpenseModel = ExpenseModel::getInstance( );
        $itemList = $ItemModel->getList( );
        $expenseList = $ExpenseModel->getList( );

        $vars['dynamic']['item'] = $vars['dynamic']['hiddenField'] = false;

        if( isset( $data['itemRow'] ) && is_array( $data['itemRow'] ) ) {
            foreach( $data['itemRow'] as $item ) {
                if( isset( $item['piID'] ) ) {
                    $title = $itemList[$item['piID']]['title'];
                }
                else {
                    $title = $expenseList[$item['eiID']];
                }

                $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => '',
                                                    'TPLVAR_HIDDEN_ID' => '',
                                                    'TPLVAR_DEDUCTION' => '',
                                                    'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                    'TPLVAR_AMOUNT' => $data['office']['currencyCode'] .
                                                                       $data['office']['currencySymbol'] . Money::format( $item['amount'] ),
                                                    'TPL_PAYROLL_ITEM_LIST' => $title,
                                                    'TPLVAR_REMARK' => $item['remark'] );
            }
        }

        $vars['TPL_PAYROLL_ITEM_LIST'] = '';
        $vars['TPL_ITEM_LIST'] = $this->View->render( 'markaxis/payroll/item.tpl', $vars );
        $vars['TPL_PROCESS_SUMMARY'] = $this->renderSavedSummary( $data );

        if( isset( $data['col_1'] ) ) $vars['TPL_COL_1'] = $data['col_1'];
        if( isset( $data['col_2'] ) ) $vars['TPL_COL_2'] = $data['col_2'];
        if( isset( $data['col_3'] ) ) $vars['TPL_COL_3'] = $data['col_3'];
        return $this->View->render( 'markaxis/payroll/processForm.tpl', $vars );
    }


    /**
     * Render summary on first process!
     * @return string
     */
    public function renderSavedSummary( $data ) {
        $summary = $this->SummaryModel->getByPID( $data['payrollInfo']['pID'] );

        if( isset( $data['userTax'] ) ) {
            foreach( $data['userTax'] as $userTax ) {
                $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $userTax['title'],
                                                                'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                                'TPLVAR_AMOUNT' => Money::format( $userTax['amount'] ),
                                                                'TPLVAR_SHOW_TIP' => 'hide',
                                                                'TPLVAR_REMARK' => $userTax['remark'] );
            }
        }

        if( $summary['claim'] ) {
            $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_CLAIM'),
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => Money::format( $summary['claim'] ),
                                                            'TPLVAR_SHOW_TIP' => 'hide',
                                                            'TPLVAR_REMARK' => '' );
        }

        if( isset( $data['levies'] ) ) {
            foreach( $data['levies'] as $levy ) {
                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $levy['title'],
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => Money::format( $levy['amount'] ),
                                                            'TPLVAR_SHOW_TIP' => 'hide',
                                                            'TPLVAR_REMARK' => '' );
            }
        }

        if( isset( $data['contributions'] ) && is_array( $data['contributions'] ) ) {
            foreach( $data['contributions'] as $contribution ) {
                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $contribution['title'],
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => Money::format( $contribution['amount'] ),
                                                            'TPLVAR_SHOW_TIP' => 'hide',
                                                            'TPLVAR_REMARK' => '' );


            }
            $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_EMPLOYER_CONTRIBUTION'),
                                                        'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                        'TPLVAR_AMOUNT' => Money::format( $summary['contribution'] ),
                                                        'TPLVAR_SHOW_TIP' => 'hide',
                                                        'TPLVAR_REMARK' => '' );
        }

        $vars['TPLVAR_CURRENCY'] = $data['office']['currencyCode'] . $data['office']['currencySymbol'];
        $vars['TPLVAR_GROSS_AMOUNT'] = Money::format( $summary['gross'] );
        $vars['TPLVAR_NET_AMOUNT'] = Money::format( $summary['net'] );

        return $this->View->render('markaxis/payroll/processSummary.tpl', array_merge( $this->L10n->getContents( ), $vars ) );
    }
}
?>