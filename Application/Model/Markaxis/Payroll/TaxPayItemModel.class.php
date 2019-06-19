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
     * @return int

    public function processPayroll( $data ) {
        if( isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
            $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );
            $itemInfo = $this->TaxPayItem->getBytrIDs( $trIDs );

            if( sizeof( $itemInfo ) > 0 ) {
                $Formula = new Formula( );

                foreach( $itemInfo as $row ) {
                    switch( $row['piID'] ) {
                        case '32' :
                            if( $row['valueType'] == 'formula' ) {
                                //
                            }
                            break;
                    }
                }

                // Parse all passes to items
                if( sizeof( $data['taxRules'] ) > 0 ) {
                    if( isset( $data['deduction'] ) ) {
                        $EmployeeModel = EmployeeModel::getInstance( );
                        $empInfo = $EmployeeModel->getFieldByUserID( $data['empInfo']['userID'], 'currency' );
                        $currency = $empInfo['currency'] ? $empInfo['currency'] : '';

                        foreach( $data['taxRules'] as $rules ) {
                            if( isset( $rules['applyType'] ) ) {
                                if( $rules['applyType'] == 'deductionOR' && isset( $rules['applyValue'] ) &&
                                    isset( $rules['applyValueType'] ) ) {

                                    if( $rules['applyValue'] ) {
                                        if( $rules['applyValueType'] == 'percentage' ) {
                                            if( isset( $rules['capped'] ) ) {
                                                $amount = $rules['capped'] * $rules['applyValue'] / 100;
                                                $remark = ' (Capped at ' . $currency . number_format( $rules['capped'] ) . ')';
                                            }
                                            else {
                                                $amount = $salary * $rules['applyValue'] / 100;
                                                $remark = '';
                                            }
                                        }
                                        if( $rules['applyValueType'] == 'fixed' ) {
                                            $amount = $rules['applyValue'];
                                            $remark = '';
                                        }
                                        $data['items'][] = array( 'piID' => $data['deduction']['piID'],
                                                                  'trID' => $rules['trID'],
                                                                  'title' => $rules['title'] . $remark,
                                                                  'amount' => $amount );
                                    }
                                }
                                if( $rules['applyType'] == 'contribution' && isset( $rules['applyValue'] ) &&
                                    isset( $rules['applyValueType'] ) ) {
                                    if( isset( $rules['capped'] ) ) {
                                        $amount = $rules['capped'] * $rules['applyValue'] / 100;
                                    }
                                    else {
                                        $amount = $data['empInfo']['salary'] * $rules['applyValue'] / 100;
                                    }
                                    $data['info'][] = array( 'title' => $rules['title'],
                                                             'amount' => $amount );
                                }
                                //unset( $data['taxRules'][$key] );
                            }
                        }
                    }
                }
                return $data;
            }
        }
    } */


    /**
     * Return total count of records
     * @return int
     */
    public function reprocessPayroll( $data, $post ) {
        //var_dump($data);
        //var_dump($post);

        /*
        array(3) {
          ["basic"]=>
          array(3) {
            ["piID"]=> string(1) "3"
            ["title"]=> string(12) "Basic Salary"
            ["basic"]=> string(1) "1"
          }
          ["deduction"]=>
          array(3) {
            ["piID"]=> string(1) "5"
            ["title"]=> string(9) "Deduction"
            ["deduction"]=> string(1) "1"
          }
          ["additional"]=>
          array(1) {
            [32]=>
            array(3) {
              ["piID"]=> string(2) "32"
              ["title"]=> string(12) "Annual Bonus"
              ["additional"]=> string(1) "1"
            }
          }
        }
        array(15) {
          ["remark_5"]=> string(0) ""
          ["amount_5"]=> string(5) "30000"
          ["itemType_5"]=> string(4) "p-32"

          ["remark_3"]=> string(6) "asdasd"
          ["amount_3"]=> string(7) "SGD$423"
          ["itemType_3"]=> string(3) "e-2"

          ["remark_2"]=> string(45) "Chinese Development Assistance Council (CDAC)"
          ["amount_2"]=> string(5) "SGD$3"
          ["itemType_2"]=> string(3) "p-5" //deduction

          ["remark_1"]=> string(34) "Employee CPF (Capped at SGD$6,000)"
          ["amount_1"]=> string(9) "SGD$1,200"
          ["itemType_1"]=> string(3) "p-5" //deduction

          ["remark_0"]=> string(0) ""
          ["amount_0"]=> string(10) "SGD$10,000"
          ["itemType_0"]=> string(3) "p-3"
        }
         * */

        $sizeof = sizeof( $post );
        $loop = $sizeof > 2 ? $sizeof/2 : 0;

        if( $loop && isset( $data['empInfo']['salary'] ) && $data['empInfo']['salary'] &&
            isset( $data['empInfo']['startDate'] ) && $data['empInfo']['startDate'] ) {

            $totalAW = array( );

            for( $i=0; $i<$loop; $i++ ) {
                if( isset( $post['itemType_' . $i] ) ) {
                    $itemType = str_replace('p-', '', $post['itemType_' . $i] );

                    if( isset( $data['additional'][$itemType] ) ) {
                        if( isset( $totalAW[$itemType] ) ) {
                            $totalAW[$itemType]['amount'] += $post['amount_' . $i];
                        }
                        else {
                            $totalAW[$itemType]['amount'] = $post['amount_' . $i];
                        }
                    }
                }
            }

            if( sizeof( $totalAW ) > 0 ) {
                // Do all assignment before loop
                $monthDiff = 0;
                $currYear = date( 'Y' );
                $dateDiff = \DateTime::createFromFormat('Y-m-d',
                                $data['empInfo']['startDate'] )->diff( new \DateTime('now') );

                foreach( $totalAW as $piID => $value ) {
                    $itemInfo = $this->getBypiID( $piID );

                    if( sizeof( $itemInfo ) > 0 && $itemInfo['valueType'] == 'formula' && $itemInfo['value'] ) {
                        if( $dateDiff->y < $currYear ) {
                            $monthDiff = 12;
                        }
                        else if( $dateDiff->y == $currYear ) {
                            $begin = new \DateTime($dateDiff->d . '-' . $dateDiff->m . '-' . $currYear );
                            $end = new \DateTime( );
                            $end = $end->modify( '+1 month' );

                            $interval = \DateInterval::createFromDateString('1 month');

                            $period = new \DatePeriod( $begin, $interval, $end );
                            foreach( $period as $dt ) {
                                $monthDiff++;
                            }
                        }

                        if( isset( $data['taxRules'][$itemInfo['trID']]['capped'] ) ) {
                            if( $data['empInfo']['salary'] > $data['taxRules'][$itemInfo['trID']]['capped'] ) {
                                $data['empInfo']['salary'] = $data['taxRules'][$itemInfo['trID']]['capped'];
                            }
                        }

                        $formula = str_replace( '{salary}', $data['empInfo']['salary'], $itemInfo['value'] );
                        $formula = str_replace( '{durationMonth}', $monthDiff, $formula );

                        $Formula = new Formula( );
                        echo $formula . '<br>';
                        var_dump( $Formula->calculate( $formula ) );
                        exit;
                    }
                }
            }
        }
        exit;
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