<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxGenderModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGenderModel extends \Model {


    // Properties
    protected $TaxGender;


    /**
     * TaxGenderModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxGender = new TaxGender( );
    }


    /**
     * Return total count of records
     * @return bool
     */
    public function isFound( $trID, $cID ) {
        return $this->TaxGender->isFound( $trID, $cID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getBytrID( $trID ) {
        return $this->TaxGender->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getAll( $data ) {
        if( isset( $data['taxRules'] ) && is_array( $data['taxRules'] ) ) {
            foreach( $data['taxRules'] as $key => $taxRule ) {
                if( $cInfo = $this->getBytrID( $taxRule['trID'] ) ) {
                    $data['taxRules'][$key]['gender'] = $cInfo;
                }
            }
            return $data['taxRules'];
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

                    if( $data['criteria_' . $id] == 'gender' ) {
                        $cInfo['gender'] = $data['gender'] == 'm' ? 'm' : 'f';

                        if( $gInfo = $this->getBytrID( $cInfo['trID'] ) ) {
                            array_push($validID, $gInfo[0]['tgID'] );

                            if( $cInfo['gender'] != $gInfo[0]['gender'] ) {
                                $this->TaxGender->update('tax_gender', $cInfo,
                                                        'WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                                      tgID = "' . (int)$gInfo[0]['tgID'] . '"' );
                            }
                        }
                        else {
                            array_push($validID, $this->TaxGender->insert('tax_gender', $cInfo) );
                        }
                        break;
                    }
                }
            }
        }
        $gender = implode( ',', $validID );
        $this->TaxGender->delete( 'tax_gender','WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                             tgID NOT IN(' . addslashes( $gender ) . ')' );
    }
}
?>