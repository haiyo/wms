<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\EmployeeModel;
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
    public function isFound( $trID, $tcID ) {
        return $this->TaxPayItem->isFound( $trID, $tcID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $tcID ) {
        return $this->TaxPayItem->getByID( $tcID );
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
     */
    public function getAll( $taxRules ) {
        if( is_array( $taxRules ) && sizeof( $taxRules ) > 0 ) {
            foreach( $taxRules as $key => $taxRule ) {
                if( $cInfo = $this->getBytrID( $taxRule['trID'] ) ) {
                    $taxRules[$key]['computing'] = $cInfo;
                }
            }
            return $taxRules;
        }
    }


    /**
     * Test against computing criteria.
     * @return bool
     */
    public function isEquality( $computing, $compare, $against ) {
        if( $computing == 'lt' || $computing == 'lte' ) {
            if( $compare > $against ) {
                return false;
            }
        }
        if( $computing == 'gt' && $compare <= $against ) {
            return false;
        }
        if( $computing == 'gte' && $compare < $against ) {
            return false;
        }
        return true;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $data ) {
        if( isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
            $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );
            $itemInfo = $this->TaxPayItem->getBytrIDs( $trIDs );

            if( sizeof( $itemInfo ) > 0 ) {
                $Formula = new Formula( );

                foreach( $itemInfo as $row ) {
                    switch( $row['piID'] ) {
                        case 'salary' :
                            if( !$data['empInfo']['salary'] ) {
                                break;
                            }
                            if( !$this->isEquality( $row['computing'], $data['empInfo']['salary'], $row['value'] ) ) {
                                unset( $data['taxRules'][$row['trID']] );
                                break;
                            }
                            if( $row['computing'] == 'ltec' ) {
                                // Set the cap amount for later deduction.
                                $data['taxRules'][$row['trID']]['capped'] = $row['value'];
                            }
                            break;

                        case '32' :
                            if( $row['valueType'] == 'formula' ) {
                                //
                            }
                            break;
                    }
                }

                // Parse all passes to items
                /*if( sizeof( $data['taxRules'] ) > 0 ) {
                    if( isset( $data['deduction'] ) ) {
                        $EmployeeModel = EmployeeModel::getInstance( );
                        $empInfo = $EmployeeModel->getFieldByUserID( $data['empInfo']['userID'], 'currency' );
                        $currency = $empInfo['currency'] ? $empInfo['currency'] : '';

                        foreach( $data['taxRules'] as $rules ) {
                            if( isset( $rules['applyType'] ) ) {
                                if( $rules['applyType'] == 'deductionSA' && isset( $rules['applyValue'] ) &&
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
                }*/
                return $data;
            }
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function reprocessPayroll( $data, $post ) {
        var_dump($data);
        var_dump($post);
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
                        /*


                                6000x17-{salary}x{durationMonth}

                                employee start date

                                get employee year
                                    - if year < currYear {
                                        12 months
                                    }
                                    else if year == currYear {
                                        $begin = ddmmCurrYear
                                        $end = new DateTime( )
                                        $end = $end->modify( '+1 month' );

                                        $interval = DateInterval::createFromDateString('1 month');

                                        $period = new DatePeriod($begin, $interval, $end);
                                        $counter = 0;
                                        foreach($period as $dt) {
                                            $counter++;
                                        }

                                        return $counter;
                                    }
                                 * */
                    }
                }
            }
        }
        $taxPayItem = implode( ',', $validID );
        $this->TaxPayItem->delete( 'tax_pay_item','WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                         tpiID NOT IN(' . addslashes( $taxPayItem ) . ')' );
    }
}