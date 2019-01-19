<?php
namespace Markaxis\Payroll;
use \Aurora\Component\DesignationModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxDesignationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxDesignationModel extends \Model {


    // Properties
    protected $TaxDesignation;



    /**
     * TaxDesignationModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxDesignation = new TaxDesignation( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $cID ) {
        return $this->TaxDesignation->isFound( $trID, $cID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $trID, $tdID ) {
        return $this->TaxDesignation->getByID( $trID, $tdID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBytrID( $trID ) {
        return $this->TaxDesignation->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getAll( $taxRules ) {
        if( is_array( $taxRules ) && sizeof( $taxRules ) > 0 ) {
            foreach( $taxRules as $key => $taxRule ) {
                if( $cInfo = $this->getBytrID( $taxRule['trID'] ) ) {
                    $taxRules[$key]['designation'] = $cInfo;
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
                return true;
            } else {
                return false;
            }
        };

        $criteria = array_filter( $data, $callback, ARRAY_FILTER_USE_KEY );
        $sizeof = sizeof( $criteria );
        $validID = array( 0 );

        $cInfo = array();
        $cInfo['trID'] = (int)$data['trID'];

        if( $sizeof > 0 ) {
            foreach( $criteria as $key => $value ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                    $id = $match[1];

                    switch( $data['criteria_' . $id] ) {
                        case 'designation' :
                            $DesignationModel = DesignationModel::getInstance();

                            if( $DesignationModel->isFound($data['designation_' . $id] ) ) {
                                $cInfo['designation'] = (int)$data['designation_' . $id];

                                if( $data['designationID_' . $id] ) {
                                    if( $ctInfo = $this->getByID($cInfo['trID'], $data['designationID_' . $id] ) ) {
                                        $this->TaxDesignation->update('tax_designation', $cInfo,
                                            'WHERE tdID = "' . (int)$data['designationID_' . $id] . '"');

                                        array_push($validID, $data['designationID_' . $id]);
                                    }
                                } else {
                                    array_push($validID, $this->TaxDesignation->insert('tax_designation', $cInfo));
                                }
                            }
                            break;
                    }
                }
            }
        }
        $designation = implode( ',', $validID );
        $this->TaxDesignation->delete( 'tax_designation','WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                                tdID NOT IN(' . addslashes( $designation ) . ')' );
    }
}
?>