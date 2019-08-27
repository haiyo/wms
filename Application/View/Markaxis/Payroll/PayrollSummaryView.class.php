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
 * @version $Id: PayrollSummaryView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollSummaryView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $PayrollSummaryModel;


    /**
    * PayrollSummaryView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->PayrollSummaryModel = PayrollSummaryModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderProcessForm( $puID, $userID, $processDate, $data ) {
        $UserImageModel = UserImageModel::getInstance( );

        $vars = array( 'TPLVAR_IMAGE' => $UserImageModel->getImgLinkByUserID( $userID ),
                       'TPLVAR_USERID' => $userID,
                       'TPLVAR_PROCESS_DATE' => $processDate );

        $PayrollUserItemModel = PayrollUserItemModel::getInstance( );
        $itemInfo = $PayrollUserItemModel->getByPuID( $puID );

        $vars['dynamic']['item'] = false;

        if( sizeof( $itemInfo ) > 0 ) {
            $ItemModel = ItemModel::getInstance( );
            $itemList = $ItemModel->getList( );

            foreach( $itemInfo as $item ) {
                $vars['dynamic']['item'][] = array( 'TPLVAR_PAYROLL_ITEM' => $itemList[$item['piID']],
                                                    'TPLVAR_AMOUNT' => $data['empInfo']['currency'] .
                                                                       number_format( $item['amount'],2 ),
                                                    'TPLVAR_REMARK' => $item['remark'] );
            }
            /*if( isset( $data['claims'] ) ) {
                foreach( $data['claims'] as $claims ) {
                    if( isset( $claims['eiID'] ) ) {
                        $selected = 'e-' . $claims['eiID'];
                        $itemType = $SelectGroupListView->build('itemType_' . $id, $fullList, $selected, 'Select Payroll Item' );

                        $vars['dynamic']['item'][] = array( 'TPLVAR_PAYROLL_ITEM' => $id,
                                                            'TPLVAR_AMOUNT' => $userInfo['currency'] .
                                                                               number_format( $claims['amount'],2 ),
                                                            'TPL_PAYROLL_ITEM_LIST' => $itemType,
                                                            'TPLVAR_REMARK' => $claims['remark'] );
                        $id++;
                    }
                }
            }*/
        }
        //$vars['TPL_PROCESS_SUMMARY'] = $this->renderProcessSummary( $data );

        if( isset( $data['col_1'] ) ) $vars['TPL_COL_1'] = $data['col_1'];
        if( isset( $data['col_2'] ) ) $vars['TPL_COL_2'] = $data['col_2'];
        if( isset( $data['col_3'] ) ) $vars['TPL_COL_3'] = $data['col_3'];
        return $this->View->render( 'markaxis/payroll/savedProcess.tpl', $vars );
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

        $vars['dynamic']['deductionSummary'] = false;
        $itemGroups = array( );

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
                $vars['dynamic']['deductionSummary'][] =
                    array( 'TPLVAR_TITLE' => $groups['title'],
                           'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                           'TPLVAR_DEDUCTION_AMOUNT' => number_format( $groups['amount'],2 ) );
            }
        }
        if( isset( $data['claims'] ) ) {
            foreach( $data['claims'] as $claims ) {
                if( isset( $claims['eiID'] ) ) {
                    $vars['TPLVAR_CLAIM_AMOUNT'] += (float)$claims['amount'];
                    $vars['TPLVAR_NET_AMOUNT'] += (float)$claims['amount'];
                }
            }
        }
        if( isset( $data['levy'] ) ) {
            foreach( $data['levy'] as $levy ) {
                $vars['TPLVAR_TOTAL_LEVY'] += (float)$levy['amount'];

                if( $levy['levyType'] == 'skillLevy' ) {
                    $vars['TPLVAR_SDL_AMOUNT'] = (float)$levy['amount'];
                }
                else {
                    $vars['TPLVAR_FWL_AMOUNT'] = (float)$levy['amount'];
                }
            }
        }

        if( isset( $data['contribution'] ) && is_array( $data['contribution'] ) ) {
            $contributionAmount = 0;

            foreach( $data['contribution'] as $contribution ) {
                $contributionAmount += $contribution['amount'];
                $vars['TPLVAR_TOTAL_CONTRIBUTION'] += (float)$contribution['amount'];
            }
            $vars['TPLVAR_CONTRIBUTION_AMOUNT'] = number_format( $contributionAmount,2 );
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
}
?>