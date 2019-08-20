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
     * @return mixed
     */
    public function getBytrID( $trID ) {
        return $this->TaxDesignation->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getAll( $data ) {
        if( isset( $data['taxRules'] ) && is_array( $data['taxRules'] ) ) {
            foreach( $data['taxRules'] as $key => $taxRule ) {
                if( $cInfo = $this->getBytrID( $taxRule['trID'] ) ) {
                    $data['taxRules'][$key]['designation'] = $cInfo;
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
        $cInfo = array( );
        $validID = array( 0 );
        $cInfo['trID'] = (int)$data['trID'];

        if( isset( $data['designation'] ) && is_array( $data['designation'] ) ) {
            // Make sure all sent in designationID are valid.
            $designationCount = sizeof( $data['designation'] );
            $designationList = implode( ',', $data['designation'] );

            $DesignationModel = DesignationModel::getInstance();
            $dbCount = $DesignationModel->getListCount( $designationList );

            if( $designationCount != $dbCount ) {
                return false;
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

            if( $sizeof > 0 ) {
                foreach( $criteria as $key => $value ) {
                    preg_match( $preg, $key, $match );

                    if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                        $id = $match[1];

                        if( $data['criteria_' . $id] == 'designation' ) {
                            if( $existing = $this->getBytrID( $cInfo['trID'] ) ) {
                                $existingIDs = array_column( $existing, 'designationID' );

                                foreach( $data['designation'] as $designationID ) {
                                    if( !in_array( $designationID, $existingIDs ) ) {
                                        $cInfo['designationID'] = $designationID;
                                        $this->TaxDesignation->insert('tax_designation', $cInfo );
                                    }
                                    array_push($validID, $designationID );
                                }
                            }
                            else {
                                foreach( $data['designation'] as $designationID ) {
                                    $cInfo['designationID'] = (int)$designationID;
                                    $this->TaxDesignation->insert('tax_designation', $cInfo );
                                    array_push($validID, $cInfo['designationID'] );
                                }
                            }
                            break;
                        }
                    }
                }
            }
        }
        $designation = implode( ',', $validID );
        $this->TaxDesignation->delete( 'tax_designation',
                                        'WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                     designationID NOT IN(' . addslashes( $designation ) . ')' );
    }
}
?>