<?php
namespace Markaxis\Payroll;
use \Library\Util\Date;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxComputingModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxComputingModel extends \Model {


    // Properties
    protected $TaxComputing;


    /**
     * TaxComputingModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxComputing = new TaxComputing( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $tcID ) {
        return $this->TaxComputing->isFound( $trID, $tcID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $tcID ) {
        return $this->TaxComputing->getByID( $tcID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBytrID( $trID ) {
        return $this->TaxComputing->getBytrID( $trID );
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
        if( ( $computing == 'gt' && $compare <= $against ) ||
            ( $computing == 'gte' && $compare < $against ) ) {
            return false;
        }
        return true;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function filterInvalidRules( $data ) {
        $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );
        $compInfo = $this->TaxComputing->getBytrIDs( $trIDs );
        $age = 0;
        $unset = array( );

        if( sizeof( $compInfo ) > 0 ) {
            foreach( $compInfo as $row ) {
                // If we have trID already unset before, skip any compInfo related;
                if( isset( $unset[$row['trID']] ) ) {
                    continue;
                }
                if( $row['criteria'] == 'age' ) {
                    if( !$age ) {
                        // If invalid age, break altogether.
                        if( $data['empInfo']['birthday'] && !$age = Date::getAge( $data['empInfo']['birthday'] ) ) {
                            unset( $data['taxRules'][$row['trID']] );
                            $unset[$row['trID']] = 1;
                            continue;
                        }
                    }
                    if( !$this->isEquality( $row['computing'], $age, $row['value'] ) ) {
                        unset( $data['taxRules'][$row['trID']] );
                        $unset[$row['trID']] = 1;
                        continue;
                    }
                }
                if( $row['criteria'] == 'ordinary' ) {
                    if( $data['empInfo']['salary'] ) {
                        if( !$this->isEquality( $row['computing'], $data['empInfo']['salary'], $row['value'] ) ) {
                            unset( $data['taxRules'][$row['trID']] );
                            $unset[$row['trID']] = 1;
                            continue;
                        }
                    }
                    if( $row['computing'] == 'ltec' ) {
                        // Set the cap amount for later deduction.
                        $data['taxRules'][$row['trID']]['capped'] = $row['value'];
                    }
                }
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $data ) {
        if( isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
            $data = $this->filterInvalidRules( $data );

            if( sizeof( $data['taxRules'] ) == 0 || !isset( $data['deduction'] ) ) {
                return $data;
            }
            // Parse all passes to items
            foreach( $data['taxRules'] as $rules ) {
                if( $rules['applyType'] == 'deductionOR' && $rules['applyValue'] ) {
                    if( $rules['applyValueType'] == 'percentage' ) {
                        if( isset( $rules['capped'] ) ) {
                            $amount = $rules['capped']*$rules['applyValue']/100;
                            $remark = ' (Capped at ' . $data['empInfo']['currency'] .
                                        number_format( $rules['capped'] ) . ')';
                        }
                        else {
                            $amount = $data['empInfo']['salary']*$rules['applyValue']/100;
                            $remark = '';
                        }
                    }
                    if( $rules['applyValueType'] == 'fixed' ) {
                        $amount = $rules['applyValue'];
                        $remark = '';
                    }
                    $data['items'][] = array( 'piID' => $data['deduction']['piID'],
                                              'trID' => $rules['trID'],
                                              'remark' => $rules['title'] . $remark,
                                              'amount' => $amount );
                }
                if( $rules['applyType'] == 'contribution' && $rules['applyValueType'] ) {
                    if( isset( $rules['capped'] ) ) {
                        $amount = $rules['capped']*$rules['applyValue']/100;
                    }
                    else {
                        $amount = $data['empInfo']['salary']*$rules['applyValue']/100;
                    }
                    $data['contribution'][$rules['trID']] = array( 'title' => $rules['title'],
                                                                   'amount' => $amount );
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
        $cInfo['trID'] = (int)$data['trID'];

        if( $sizeof > 0 ) {
            foreach( $criteria as $key => $value ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                    $id = $match[1];

                    switch( $data['criteria_' . $id] ) {
                        case 'age' :
                        case 'ordinary' :
                        case 'workforce' :
                            if( isset( $data['computing_' . $id] ) && isset( $data['valueType_' . $id] ) &&
                                isset( $data['value_' . $id] ) ) {

                                if( $data['computing_' . $id] == 'lt' || $data['computing_' . $id] == 'gt' ||
                                    $data['computing_' . $id] == 'lte' || $data['computing_' . $id] == 'ltec' ||
                                    $data['computing_' . $id] == 'gte' || $data['computing_' . $id] == 'eq' ) {
                                    $computing = $data['computing_' . $id];

                                    if( $data['valueType_' . $id] == 'fixed' || $data['valueType_' . $id] == 'percentage' ) {
                                        $valueType = $data['valueType_' . $id];
                                    }
                                    $value = (float)$data['value_' . $id];

                                    $cInfo['criteria'] = $data['criteria_' . $id];
                                    $cInfo['computing'] = $computing;
                                    $cInfo['valueType'] = $valueType;
                                    $cInfo['value'] = $value;

                                    if( $data['tcID_' . $id] ) {
                                        if( $this->isFound( $cInfo['trID'], $data['tcID_' . $id] ) ) {
                                            $this->TaxComputing->update('tax_computing', $cInfo,
                                                                        'WHERE tcID = "' . (int)$data['tcID_' . $id] . '"' );

                                            array_push($validID, $data['tcID_' . $id]);
                                        }
                                    } else {
                                        array_push($validID, $this->TaxComputing->insert('tax_computing', $cInfo));
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }
        $computing = implode( ',', $validID );
        $this->TaxComputing->delete( 'tax_computing','WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                                   tcID NOT IN(' . addslashes( $computing ) . ')' );
    }
}