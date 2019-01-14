<?php
namespace Markaxis\Payroll;
use \Library\IO\File;

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

        File::import( DAO . 'Markaxis/Payroll/TaxComputing.class.php' );
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
                        case 'salary' :
                        case 'workforce' :
                            if( isset( $data['computing_' . $id] ) && isset($data['valueType_' . $id]) &&
                                isset( $data['value_' . $id] ) ) {

                                if( $data['computing_' . $id] == 'lt' || $data['computing_' . $id] == 'gt' ||
                                    $data['computing_' . $id] == 'lte' || $data['computing_' . $id] == 'gte' ||
                                    $data['computing_' . $id] == 'eq' ) {
                                    $computing = $data['computing_' . $id];
                                }
                                if( $data['valueType_' . $id] == 'fixed' || $data['valueType_' . $id] == 'percentage' ) {
                                    $valueType = $data['valueType_' . $id];
                                }
                                $value = (int)$data['value_' . $id];

                                $cInfo['criteria'] = $data['criteria_' . $id];
                                $cInfo['computing'] = $computing;
                                $cInfo['valueType'] = $valueType;
                                $cInfo['value'] = $value;

                                if( $data['tcID_' . $id] ) {
                                    if( $this->isFound($cInfo['trID'], $data['tcID_' . $id] ) ) {
                                        $this->TaxComputing->update('tax_computing', $cInfo,
                                            'WHERE tcID = "' . (int)$data['tcID_' . $id] . '"' );

                                        array_push($validID, $data['tcID_' . $id]);
                                    }
                                } else {
                                    array_push($validID, $this->TaxComputing->insert('tax_computing', $cInfo));
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