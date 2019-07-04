<?php
namespace Markaxis\Payroll;
use \Library\Util\Formula;

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
    public function getBytrIDs( $trIDs, $piID=false ) {
        return $this->TaxPayItem->getBytrIDs( $trIDs, $piID );
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
    public function processPayroll( $data ) {
        if( isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
            $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );
            $payItemRules = $this->getBytrIDs( $trIDs );

            // Firstly do we have items coming in?
            if( isset( $data['items'] ) ) {
                // if so then we get all the related piID from the items
                $piIDs = array_unique( array_column( $data['items'], 'piID' ) );
            }
            foreach( $payItemRules as $rule ) {
                // 1. If list of $payItemRules doesnt even exist in items, we just unset;
                // 2. OR if we do have items but our payItemRules doesn't apply, unset;
                if( !isset( $data['items'][$rule['piID']] ) || !in_array( $rule['piID'], $piIDs ) ) {
                    unset( $data['taxRules'][$rule['trID']] );
                }
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function reprocessPayroll( $data, $post ) {
        if( isset( $post['amountInput'] ) && isset( $post['itemType'] ) ) {
            if( isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
                $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );
                $itemInfo = $this->getBytrIDs( $trIDs, $post['itemType'] );

                if( sizeof( $itemInfo ) > 0 ) {
                    foreach( $itemInfo as $row ) {
                        if( $row['valueType'] == 'formula' && $row['value'] ) {
                            $salary = $data['empInfo']['salary'];

                            if( isset( $data['taxRules'][$row['trID']]['capped'] ) &&
                                $salary > $data['taxRules'][$row['trID']]['capped'] ) {
                                // Salary capped
                                $salary = $data['taxRules'][$row['trID']]['capped'];
                            }
                            $formula = str_replace('{salary}', $salary, $row['value'] );
                            $formula = str_replace('{durationMonth}', $data['empInfo']['monthDiff'], $formula );

                            // AW Ceiling
                            $Formula = new Formula( );
                            $capAmount = $Formula->calculate( $formula );
                            $remark = '';

                            // Get all AW paid within this year (if any) to check if the total hit ceiling!
                            // var_dump( array_keys( $data['additional']) ); exit;

                            $amount = $post['amountInput'];
                            $total = $this->getTotalAWPostCount( $data, $post );

                            if( isset( $total['totalAW'] ) && $total['totalAW'] > $capAmount ) {
                                // Check if previously capped before
                                if( $total['totalAW']-$post['amountInput'] >= $capAmount ) {
                                    return 0;
                                }
                                else if( $total['totalAW'] < $capAmount ) {
                                    $amount = $total['totalAW'];
                                }
                                else {
                                    $amount = $capAmount;
                                }
                                $remark .= ' (Capped at ' . $data['empInfo']['currency'] . number_format( $capAmount ) . ')';
                            }
                            if( isset( $data['taxRules'][$row['trID']]['applyType'] ) &&
                                isset( $data['taxRules'][$row['trID']]['applyValueType'] ) &&
                                isset( $data['taxRules'][$row['trID']]['applyValue'] ) ) {

                                $applyType = $data['taxRules'][$row['trID']]['applyType'];
                                $applyValueType = $data['taxRules'][$row['trID']]['applyValueType'];
                                $applyValue = $data['taxRules'][$row['trID']]['applyValue'];

                                if( $applyValueType == 'percentage' && $applyValue ) {
                                    $amount = $amount*$applyValue/100;

                                    if( $applyType == 'deductionAW' ) {
                                        $afterDeduct = $amount-$total['deductionAW'];

                                        if( $afterDeduct ) {
                                            $data['gross'][] = array( 'amount' => $post['amountInput'] );
                                            $data['net'][] = array( 'amount' => $afterDeduct );
                                            $remark = $data['taxRules'][$row['trID']]['title'] . $remark;

                                            $data['items'][] = //$data['addItem'][] =
                                                array( 'piID' => $data['deductionAW']['piID'],
                                                       'trID' => $row['trID'],
                                                       'remark' => $remark,
                                                       'amount' => $amount );
                                        }
                                    }
                                    if( $applyType == 'contribution' ) {
                                        $data['contribution'][] = array( 'title' => $data['taxRules'][$row['trID']]['title'],
                                                                         'amount' => $amount );
                                    }
                                }
                                unset( $data['taxRules'][$row['trID']] );
                            }
                        }
                    }
                }
            }
            return $data;
        }
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