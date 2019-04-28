<?php
namespace Markaxis\Payroll;
use \Aurora\Component\RaceModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxRaceModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRaceModel extends \Model {


    // Properties
    protected $TaxRace;


    /**
     * TaxRaceModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxRace = new TaxRace( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $tcID ) {
        return $this->TaxRace->isFound( $trID, $tcID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $trID, $tcID ) {
        return $this->TaxRace->getByID( $trID, $tcID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBytrID( $trID ) {
        return $this->TaxRace->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getAll( $taxRules ) {
        if( is_array( $taxRules ) && sizeof( $taxRules ) > 0 ) {
            foreach( $taxRules as $key => $taxRule ) {
                if( $cInfo = $this->getBytrID( $taxRule['trID'] ) ) {
                    $taxRules[$key]['race'] = $cInfo;
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
        if( isset( $data['race'] ) && is_array( $data['race'] ) && sizeof( $data['race'] > 0 ) ) {
            // Make sure all sent in raceID are valid.
            $RaceModel = RaceModel::getInstance( );
            $raceList = $RaceModel->getList( );

            foreach( $data['race'] as $raceID ) {
                if( !isset( $raceList[$raceID] ) ) {
                    return false;
                }
            }
            $preg = '/^criteria_(\d)+/';

            $callback = function( $val ) use( $preg ) {
                if( preg_match( $preg, $val, $match ) ) {
                    return true;
                } else {
                    return false;
                }
            };

            $criteria = array_filter( $data, $callback, ARRAY_FILTER_USE_KEY );
            $sizeof = sizeof( $criteria );
            $validID = array( 0 );

            $cInfo = array( );
            $cInfo['trID'] = (int)$data['trID'];

            if( $sizeof > 0 ) {
                foreach( $criteria as $key => $value ) {
                    preg_match( $preg, $key, $match );

                    if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                        $id = $match[1];

                        if( $data['criteria_' . $id] == 'race' ) {
                            if( $rInfo = $this->getBytrID( $cInfo['trID'] ) ) {
                                $existingRaceIDs = array_column( $rInfo, 'raceID' );

                                foreach( $data['race'] as $raceID ) {
                                    if( !in_array( $raceID, $existingRaceIDs ) ) {
                                        $cInfo['raceID'] = $raceID;
                                        $this->TaxRace->insert('tax_race', $cInfo );
                                    }
                                    array_push($validID, $raceID );
                                }
                            }
                            else {
                                foreach( $data['race'] as $raceID ) {
                                    $cInfo['raceID'] = (int)$raceID;
                                    array_push($validID, $this->TaxRace->insert('tax_race', $cInfo ) );
                                }
                            }
                            break;
                        }
                    }
                }
            }
            $race = implode( ',', $validID );
            $this->TaxRace->delete( 'tax_race','WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                                   raceID NOT IN(' . addslashes( $race ) . ')' );
        }
    }
}
?>