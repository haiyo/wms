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
    private $unsetRules = [];


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
    public function getBytrIDs( $trIDs ) {
        return $this->TaxComputing->getBytrIDs( $trIDs );
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
        if( !$compare || (( $computing == 'lt' || $computing == 'lte' ) && $compare > $against ) ) {
            return false;
        }
        if( ( $computing == 'gt' && $compare <= $against ) ||
            ( $computing == 'gte' && $compare < $against ) ) {
            return false;
        }
        return true;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function filterAge( $data, $compInfo ) {
        if( $compInfo['criteria'] == 'age' && $data['empInfo']['birthday'] ) {
            $age = Date::getAge( $data['empInfo']['birthday'] );

            if( !$age || !$this->isEquality( $compInfo['computing'], $age, $compInfo['value'] ) ) {
                // If invalid age, break altogether.
                unset( $data['taxRules'][$compInfo['trID']] );
                $this->unsetRules[$compInfo['trID']] = 1;
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function filterConfirmation( $data, $compInfo ) {
        if( $compInfo['criteria'] == 'confirmation' && $data['empInfo']['confirmDate'] ) {
            // We only support current now
            if( $compInfo['valueType'] == 'current' ) {
                $current = new \DateTime( );

                if( !$this->isEquality( $compInfo['computing'], $current, $data['empInfo']['confirmDate'] ) ) {
                    unset( $data['taxRules'][$compInfo['trID']] );
                    $this->unsetRules[$compInfo['trID']] = 1;
                }
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function filterOrdinary( $data, $compInfo ) {
        if( $compInfo['criteria'] == 'ordinary' ) {
            if( !$this->isEquality( $compInfo['computing'], $data['items']['totalOrdinary'], $compInfo['value'] ) ) {
                unset( $data['taxRules'][$compInfo['trID']] );
                $this->unsetRules[$compInfo['trID']] = 1;
            }
            else if( isset( $data['taxRules'][$compInfo['trID']] ) && $compInfo['computing'] == 'ltec' &&
                     $data['items']['totalOrdinary'] > $compInfo['value'] ) {
                // Set the cap amount for later deduction.
                $data['taxRules'][$compInfo['trID']]['capped'] = $compInfo['value'];
                $data['items']['totalNett'] = $compInfo['value'];
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function filterAllPayItem( $data, $compInfo ) {
        if( $compInfo['criteria'] == 'allPayItem' ) {
            if( !$this->isEquality( $compInfo['computing'], $data['items']['totalOrdinary'], $compInfo['value'] ) ) {
                unset( $data['taxRules'][$compInfo['trID']] );
                $this->unsetRules[$compInfo['trID']] = 1;
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function filterInvalidRules( $data, $post=false ) {
        if( isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
            $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );

            $compInfo = $this->TaxComputing->getBytrIDs( $trIDs );

            if( sizeof( $compInfo ) > 0 ) {
                foreach( $compInfo as $row ) {
                    // Multiple computing criteria can belong to one TaxRule.
                    // If we have the main TaxRule already unset before, skip any compInfo related;
                    if( isset( $this->unsetRules[$row['trID']] ) ) {
                        continue;
                    }
                    $data = $this->filterAge( $data, $row );
                    $data = $this->filterOrdinary( $data, $row );
                    $data = $this->filterConfirmation( $data, $row );
                    $data = $this->filterAllPayItem( $data, $row );
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
        return $this->filterInvalidRules( $data );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function reprocessPayroll( $data, $post ) {
        return $this->filterInvalidRules( $data, $post );
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
                        case 'allPayItem' :
                        case 'workforce' :
                        case 'confirmation' :
                            if( isset( $data['computing_' . $id] ) && isset( $data['valueType_' . $id] ) ) {

                                if( $data['computing_' . $id] == 'lt' || $data['computing_' . $id] == 'gt' ||
                                    $data['computing_' . $id] == 'lte' || $data['computing_' . $id] == 'ltec' ||
                                    $data['computing_' . $id] == 'gte' || $data['computing_' . $id] == 'eq' ) {
                                    $computing = $data['computing_' . $id];
                                    $valueType = $data['valueType_' . $id];

                                    /*if( $data['valueType_' . $id] == 'fixed' || $data['valueType_' . $id] == 'percentage' ) {
                                        $valueType = $data['valueType_' . $id];
                                    }*/

                                    $cInfo['criteria'] = $data['criteria_' . $id];
                                    $cInfo['computing'] = $computing;
                                    $cInfo['valueType'] = $valueType;

                                    if( isset( $data['value_' . $id] ) ) {
                                        $cInfo['value'] = (float)$data['value_' . $id];
                                    }

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