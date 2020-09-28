<?php
namespace Markaxis\Payroll;
use \Markaxis\Company\OfficeModel AS M_OfficeModel;
use \Library\Util\Formula;
use \Library\Util\Money;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxPayItemModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxPayItemModel extends \Model {


    // Properties
    protected $TaxPayItem;


    /**
     * TaxFormulaModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxPayItem = new TaxPayItem( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBypiID( $piID ) {
        return $this->TaxPayItem->getBypiID( $piID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBytrID( $trID ) {
        return $this->TaxPayItem->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getBytrIDs( $trIDs ) {
        return $this->TaxPayItem->getBytrIDs( $trIDs );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalAWPostCount( $data, $post ) {
        $sizeof = sizeof( $post['data'] );
        $sizeof = $sizeof > 2 ? round($sizeof/2)+1 : 0;
        $total  = array( );
        $total['totalAW'] = $total['deductionAW'] = 0;

        if( $sizeof ) {
            for( $i=0; $i<$sizeof; $i++ ) {
                if( isset( $post['data']['itemType_' . $i] ) ) {
                    $itemType = str_replace('p-', '', $post['data']['itemType_' . $i] );
                    $amount = str_replace( $data['empInfo']['currency'], '', $post['data']['amount_' . $i] );
                    $amount = (int)str_replace( ',', '', $amount );

                    if( isset( $data['additional'][$itemType] ) ) {
                        if( isset( $total['totalAW'] ) ) {
                            $total['totalAW'] += $amount;
                        }
                        else {
                            $total['totalAW'] = $amount;
                        }
                    }
                    if( isset( $data['deductionAW']['piID'] ) && $data['deductionAW']['piID'] == $itemType ) {
                        if( isset( $total['deductionAW'] ) ) {
                            $total['deductionAW'] += $amount;
                        }
                        else {
                            $total['deductionAW'] = $amount;
                        }
                    }
                }
            }
        }
        return $total;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $data, $post=false, $addGross=false ) {
        if( isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
            $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );
            $payItemRules = $this->getBytrIDs( $trIDs );
            $piIDs = array( );

            // Firstly do we have items coming in?
            if( isset( $post['postItems'] ) ) {
                // if so then we get all the related piID from the items
                $piIDs = array_unique( array_column( $post['postItems'], 'piID' ) );
            }

            // If already saved, do we have existing itemRow?
            if( isset( $data['itemRow'] ) ) {
                // if so then we get all the related piID from the items
                $itemRow = array_unique( array_column( $data['itemRow'], 'piID' ) );

                if( sizeof( $itemRow ) > 0 ) {
                    foreach( $itemRow as $piID) {
                        array_push($piIDs, $piID );
                    }
                }
            }

            foreach( $payItemRules as $rule ) {
                // 1. If list of $payItemRules doesnt even exist in items, we just unset;
                // 2. OR if we do have items but our payItemRules doesn't apply, unset;
                if( !in_array( $rule['piID'], $piIDs ) ) {
                    unset( $data['taxRules'][$rule['trID']] );
                }
            }
            $data = $this->processFormula( $data, $addGross );
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return mixed
    */
    public function reprocessPayroll( $data, $post ) {
        if( !isset( $post['postItems'] ) ) {
            return $data;
        }

        $data = $this->processPayroll( $data, $post, true );

        foreach( $post['postItems'] as $postItem ) {
            if( $data['items']['deduction']['piID'] == $postItem['piID'] ) {
                $data['deductGross'][] = $postItem['amount'];
            }
            else {
                // Find all ordinary
                $ordinaryPiIDs = array_unique( array_column( $data['items']['ordinary'],'piID' ) );

                if( in_array( $postItem['piID'], $ordinaryPiIDs ) ) {
                    //$data['addGross'][] = $postItem['amount'];
                }
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function processFormula( $data, $addGross=true ) {
        $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );

        $itemInfo = $this->getBytrIDs( $trIDs );

        if( sizeof( $itemInfo ) > 0 ) {
            $PayrollModel = PayrollModel::getInstance( );
            $M_OfficeModel = M_OfficeModel::getInstance( );

            foreach( $itemInfo as $item ) {
                if( $item['valueType'] == 'formula' && $item['value'] ) {

                    // Get total ordinary of the Year and add current month ordinary as well.
                    $totalOrdinary = $PayrollModel->calculateCurrYearOrdinary( $data['empInfo']['userID'] );
                    $totalOrdinary['amount'] += $data['items']['totalOrdinary'];

                    $totalWorkDaysOfYear = $M_OfficeModel->getWorkingDaysByRange( $data['office']['oID'],
                        new \DateTime( $data['payCal']['processDate']->format('Y-01-01' ) ),
                        new \DateTime(date('Y-m-d', strtotime('last day of december ' .
                                            $data['payCal']['processDate']->format('Y') ) ) . ' 23:59:59' ) );

                    $formula = str_replace('{basic}', $data['items']['totalOrdinary'], $item['value'] );
                    $formula = str_replace('{totalWorkDaysOfYear}', $totalWorkDaysOfYear, $formula );
                    $formula = str_replace('{totalOrdinary}', $totalOrdinary['amount'], $formula );
                    $formula = str_replace('{durationMonth}', $data['empInfo']['joinMonth'], $formula );

                    $Formula = new Formula( );
                    $calculatedAmount = round( $Formula->calculate( $formula ) );
                    $data['inputRemark'] = '';

                    if( isset( $data['taxRules'][$item['trID']]['applyType'] ) &&
                        isset( $data['taxRules'][$item['trID']]['applyValueType'] ) &&
                        isset( $data['taxRules'][$item['trID']]['applyValue'] ) &&
                        isset( $data['taxRules'][$item['trID']]['applyCapped'] ) ) {

                        $applyType = $data['taxRules'][$item['trID']]['applyType'];
                        $applyValueType = $data['taxRules'][$item['trID']]['applyValueType'];
                        $applyValue = $data['taxRules'][$item['trID']]['applyValue'];
                        $applyCapped = $data['taxRules'][$item['trID']]['applyCapped'];

                        if( $applyValueType == 'percentage' && $applyValue ) {
                            $amountAfter = $calculatedAmount*$applyValue/100;

                            if( $applyCapped ) {
                                $formula = str_replace('{basic}', $data['items']['totalOrdinary'], $item['value'] );
                                $formula = str_replace('{totalWorkDaysOfYear}', $totalWorkDaysOfYear, $formula );
                                $formula = str_replace('{totalOrdinary}', $totalOrdinary['amount'], $formula );
                                $formula = str_replace('{durationMonth}', $data['empInfo']['joinMonth'], $formula );

                                $capAmount = round( $Formula->calculate( $formula ) );

                                if( $amountAfter > $capAmount ) {
                                    //$amount = $capAmount;

                                    $data['inputRemark'] .= '(Capped at ' . $data['office']['currencyCode'] .
                                                                            $data['office']['currencySymbol'] . Money::format( $capAmount ) . ')';
                                }
                            }

                            if( $applyType == 'deductionAW' ) {
                                // $remark = $data['taxRules'][$row['trID']]['title']; //. $remark;

                                foreach( $data['taxGroups']['mainGroup'] as $taxGroup ) {
                                    // First find all the childs in this group and see if we have any summary=1
                                    if( isset( $taxGroup['child'] ) ) {
                                        $tgIDChilds = array_unique( array_column( $taxGroup['child'],'tgID' ) );

                                        if( isset( $data['taxRules'][$item['trID']]['tgID'] ) && in_array( $data['taxRules'][$item['trID']]['tgID'], $tgIDChilds ) ) {
                                            foreach( $taxGroup['child'] as $child ) {
                                                if( isset( $child['tgID'] ) && $child['tgID'] == $data['taxRules'][$item['trID']]['tgID'] ) {
                                                    if( $child['summary'] ) {
                                                        $ruleTitle = $child['title'];
                                                        break 2;
                                                    }
                                                    else {
                                                        $ruleTitle = $data['taxGroups']['mainGroup'][$child['parent']]['title'];
                                                        break 2;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else if( $taxGroup['tgID'] == $data['taxRules'][$item['trID']]['tgID'] ) {
                                        $ruleTitle = $taxGroup['title'];
                                        break;
                                    }
                                }

                                $data['itemRow'][] = //$data['addItem'][] =
                                    array( 'piID' => $data['items']['deductionAW']['piID'],
                                           'trID' => $item['trID'],
                                           'tgID' => $data['taxRules'][$item['trID']]['tgID'],
                                           'deductionAW' => 1,
                                           'title' => $ruleTitle,
                                           'amount' => $amountAfter,
                                           'remark' => $data['inputRemark'] );

                                if( $addGross ) {
                                    $data['addGross'][] = $data['inputAmount'] = $calculatedAmount;
                                }
                                //$data['items']['totalGross'] += $calculatedAmount;
                            }

                            if( $applyType == 'contribution' ) {
                                $formula = str_replace('{basic}', $data['items']['totalOrdinary'], $item['value'] );
                                $formula = str_replace('{totalWorkDaysOfYear}', $totalWorkDaysOfYear, $formula );
                                $formula = str_replace('{totalOrdinary}', $totalOrdinary['amount'], $formula );
                                $formula = str_replace('{durationMonth}', $data['empInfo']['joinMonth'], $formula );

                                $capAmount = round( $Formula->calculate( $formula ) );

                                if( $amountAfter > $capAmount ) {
                                    $amountAfter = $capAmount;
                                    $data['inputRemark'] .= '(Capped at ' . $data['office']['currencyCode'] .
                                                                            $data['office']['currencySymbol'] . Money::format( $capAmount ) . ')';
                                }

                                $data['contribution'][] = array( 'title' => $data['taxRules'][$item['trID']]['title'],
                                                                 'trID' => $item['trID'],
                                                                 'amount' => round( $amountAfter ),
                                                                 'remark' => $data['inputRemark'] );
                            }
                        }
                    }
                    $data['inputAmount'] = $data['office']['currencyCode'] .
                                           $data['office']['currencySymbol'] . Money::format( $calculatedAmount );
                    unset( $data['taxRules'][$item['trID']] );
                }
            }
        }
        return $data;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function saveTaxRule( $data ) {
        $preg = '/^criteria_(\d)+/';
        $callback = function( $val ) use( $preg ) {
            if( preg_match( $preg, $val, $match ) ) {
                return $match;
            } else {
                return false;
            }
        };
        $criteria = array_filter( $data, $callback, ARRAY_FILTER_USE_KEY );
        $sizeof = sizeof( $criteria );
        $validID = array(0);
        $cInfo = array( );
        $itemList = false;
        $cInfo['trID'] = (int)$data['trID'];

        if( $sizeof > 0 ) {
            foreach( $criteria as $key => $value ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                    $id = $match[1];

                    switch( $data['criteria_' . $id] ) {
                        case 'payItem' :
                            if( isset( $data['payItem_' . $id] ) && isset( $data['valueType_' . $id] ) &&
                                isset( $data['value_' . $id] ) ) {

                                // Make sure only load once (cache)
                                if( !$itemList ) {
                                    $ItemModel = ItemModel::getInstance( );
                                    $itemList = $ItemModel->getList( );
                                }

                                if( isset( $itemList[$data['payItem_' . $id]] ) ) {
                                    if( $data['valueType_' . $id] == 'fixed' || $data['valueType_' . $id] == 'percentage' ) {
                                        $valueType = $data['valueType_' . $id];
                                        $value = (float)$data['value_' . $id];
                                    }
                                    else if( $data['valueType_' . $id] == 'formula' ) {
                                        // Custom Formula
                                        $valueType = 'formula';
                                        $value = $data['value_' . $id]; // Store formula "as is";
                                    }

                                    $cInfo['piID'] = $data['payItem_' . $id];
                                    $cInfo['valueType'] = $valueType;
                                    $cInfo['value'] = $value;

                                    if( $data['tpiID_' . $id] ) {
                                        if( $this->isFound( $cInfo['trID'], $data['tpiID_' . $id] ) ) {
                                            $this->TaxPayItem->update( 'tax_pay_item', $cInfo,
                                                                       'WHERE tpiID = "' . (int)$data['tpiID_' . $id] . '"' );

                                            array_push($validID, $data['tpiID_' . $id]);
                                        }
                                    } else {
                                        array_push($validID, $this->TaxPayItem->insert('tax_pay_item', $cInfo ) );
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }
        $taxPayItem = implode( ',', $validID );
        $this->TaxPayItem->delete( 'tax_pay_item','WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                         tpiID NOT IN(' . addslashes( $taxPayItem ) . ')' );
    }
}