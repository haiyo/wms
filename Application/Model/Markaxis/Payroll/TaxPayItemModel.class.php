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
    public function getTitle( $data, $tgID ) {
        $ruleTitle = '';

        foreach( $data['taxGroups']['mainGroup'] as $taxGroup ) {
            // First find all the childs in this group and see if we have any summary=1
            if( isset( $taxGroup['child'] ) ) {
                $tgIDChilds = array_unique( array_column( $taxGroup['child'],'tgID' ) );

                if( in_array( $tgID, $tgIDChilds ) ) {
                    foreach( $taxGroup['child'] as $child ) {
                        if( isset( $child['tgID'] ) && $child['tgID'] == $tgID ) {
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
            else if( $taxGroup['tgID'] == $tgID ) {
                $ruleTitle = $taxGroup['title'];
                break;
            }
        }
        return $ruleTitle;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $data, $post ) {
        if( isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
            $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );
            $payItemRules = $this->getBytrIDs( $trIDs );
            $piIDs = array( );

            // Firstly do we have items coming in?
            if( isset( $data['postItems'] ) ) {
                // if so then we get all the related piID from the items
                $piIDs = array_unique( array_column( $data['postItems'], 'piID' ) );
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
        }

        if( isset( $data['postItems'] ) ) {
            // if so then we get all the related piID from the items
            $trIDs = implode(', ', array_column( $data['taxRules'],'trID' ) );
            $taxPayItem = $this->getBytrIDs( $trIDs );

            $PayrollModel = PayrollModel::getInstance( );
            $M_OfficeModel = M_OfficeModel::getInstance( );

            // Get total ordinary of the Year and add current month ordinary as well.
            $totalOrdinary = $PayrollModel->getUserTotalOWByRange( $data['empInfo']['userID'] );

            // For this month, minus off any deduction.
            if( isset( $data['deductGross'] ) ) {
                foreach( $data['deductGross'] as $deductGross ) {
                    $totalOrdinary -= (float)$deductGross;
                }
            }

            $totalWorkDaysOfYear = $M_OfficeModel->getWorkingDaysByRange( $data['office']['oID'],
                new \DateTime( $data['payCal']['processDate']->format('Y-01-01' ) ),
                new \DateTime(date('Y-m-d', strtotime('last day of december ' .
                        $data['payCal']['processDate']->format('Y') ) ) . ' 23:59:59' ) );

            $processID = isset( $post['processID'] ) ? str_replace('p-', '', $post['processID'] ) : 0;

            foreach( $data['postItems'] as $postItem ) {
                $amount = (int)$postItem['amount'];

                if( isset( $postItem['additional'] ) ) {
                    foreach( $taxPayItem as $item ) {
                        if( $postItem['piID'] == $item['piID'] && !$amount ) {
                            $amount = $this->calculateAmount( $data, $item, $totalOrdinary, $totalWorkDaysOfYear );
                        }

                        if( isset( $data['taxRules'][$item['trID']] ) ) {
                            $ruleTitle = $this->getTitle( $data, $data['taxRules'][$item['trID']]['tgID'] );

                            $info = $this->processFormula( $data, $item, $amount, $totalOrdinary, $totalWorkDaysOfYear );

                            if( $data['taxRules'][$item['trID']]['applyType'] == 'deductionAW' ) {
                                $data['userTaxes'][] = array( 'trID' => $item['trID'],
                                                              'tgID' => $data['taxRules'][$item['trID']]['tgID'],
                                                              'title' => $ruleTitle,
                                                              'amount' => (int)$info['amount'],
                                                              'remark' => $info['inputRemark'] );

                                $data['deductNet'][] = (int)$info['amount'];
                                $data['addGrossAW'][] = $data['inputAmount'] = $amount;
                            }

                            if( $data['taxRules'][$item['trID']]['applyType'] == 'contribution' ) {
                                $data['contributions'][] = array( 'title' => $ruleTitle,
                                    'trID' => $item['trID'],
                                    'amount' => ceil( $info['amount'] ),
                                    'remark' => $info['inputRemark'] );
                            }

                            if( $postItem['piID'] == $processID ) {
                                $data['populate'] = array( 'processID' => $post['processID'],
                                                           'inputRemark' => $info['inputRemark'],
                                                           'inputAmount' => $data['office']['currencyCode'] .
                                                                            $data['office']['currencySymbol'] . Money::format( $amount ) );
                            }

                            unset( $data['taxRules'][$item['trID']] );
                        }
                    }
                }
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function calculateAmount( $data, $item, $totalOrdinary, $totalWorkDaysOfYear ) {
        $formula = str_replace('{basic}', $data['empInfo']['salary'], $item['value'] );
        $formula = str_replace('{totalWorkDaysOfYear}', $totalWorkDaysOfYear, $formula );
        $formula = str_replace('{totalOrdinary}', $totalOrdinary, $formula );
        $formula = str_replace('{durationMonth}', $data['empInfo']['joinMonth'], $formula );

        $Formula = new Formula( );
        return round( $Formula->calculate( $formula ) );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function processFormula( $data, $rules, $calculatedAmount, $totalOrdinary, $totalWorkDaysOfYear ) {
        $info = array( );
        $info['amount'] = 0;
        $info['inputRemark'] = '';

        if( $rules['valueType'] == 'formula' && $rules['value'] ) {
            if( isset( $data['taxRules'][$rules['trID']]['applyType'] ) &&
                isset( $data['taxRules'][$rules['trID']]['applyValueType'] ) &&
                isset( $data['taxRules'][$rules['trID']]['applyValue'] ) &&
                isset( $data['taxRules'][$rules['trID']]['applyCapped'] ) ) {

                $applyType = $data['taxRules'][$rules['trID']]['applyType'];
                $applyValueType = $data['taxRules'][$rules['trID']]['applyValueType'];
                $applyValue = $data['taxRules'][$rules['trID']]['applyValue'];
                $applyCapped = $data['taxRules'][$rules['trID']]['applyCapped'];

                if( $applyValueType == 'percentage' && $applyValue ) {
                    if( $applyCapped ) {
                        $formula = str_replace('{basic}', $data['empInfo']['salary'], $applyCapped );
                        $formula = str_replace('{totalOrdinary}', $totalOrdinary, $formula );
                        $formula = str_replace('{totalWorkDaysOfYear}', $totalWorkDaysOfYear, $formula );
                        $formula = str_replace('{totalOrdinary}', $totalOrdinary, $formula );
                        $formula = str_replace('{durationMonth}', $data['empInfo']['joinMonth'], $formula );

                        $Formula = new Formula( );
                        $capAmount = round( $Formula->calculate( $formula ) );

                        if( $calculatedAmount > $capAmount ) {
                            $info['amount'] = $capAmount*$applyValue/100;

                            $info['inputRemark'] .= '(Capped at ' . $data['office']['currencyCode'] .
                                                                    $data['office']['currencySymbol'] . Money::format( $capAmount ) . ')';
                        }
                        else {
                            $info['amount'] = $calculatedAmount*$applyValue/100;
                        }
                    }
                }
            }
        }
        return $info;
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