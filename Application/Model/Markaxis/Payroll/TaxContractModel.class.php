<?php
namespace Markaxis\Payroll;
use \Aurora\Component\ContractModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxContractModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxContractModel extends \Model {


    // Properties
    protected $TaxContract;


    /**
     * TaxContractModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxContract = new TaxContract( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $tcID ) {
        return $this->TaxContract->isFound( $trID, $tcID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $trID, $tcID ) {
        return $this->TaxContract->getByID( $trID, $tcID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getBytrID( $trID ) {
        return $this->TaxContract->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getAll( $data ) {
        if( isset( $data['taxRules'] ) && is_array( $data['taxRules'] ) ) {
            foreach( $data['taxRules'] as $key => $taxRule ) {
                if( $cInfo = $this->getBytrID( $taxRule['trID'] ) ) {
                    $data['taxRules'][$key]['contract'] = $cInfo;
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

        if( isset( $data['contract'] ) && is_array( $data['contract'] ) ) {
            // Make sure all sent in contractID are valid.
            $contractCount = sizeof( $data['contract'] );
            $contractList = implode( ',', $data['contract'] );

            $ContractModel = ContractModel::getInstance( );
            $dbCount = $ContractModel->getListCount( $contractList );

            if( $contractCount != $dbCount ) {
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

            foreach( $criteria as $key => $value ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                    $id = $match[1];

                    if( $data['criteria_' . $id] == 'contract' ) {
                        if( $existing = $this->getBytrID( $cInfo['trID'] ) ) {
                            $existingIDs = array_column( $existing, 'contractID' );

                            foreach( $data['contract'] as $contractID ) {
                                if( !in_array( $contractID, $existingIDs ) ) {
                                    $cInfo['contractID'] = $contractID;
                                    $this->TaxContract->insert('tax_contract', $cInfo );
                                }
                                array_push($validID, $contractID );
                            }
                        }
                        else {
                            foreach( $data['contract'] as $contractID ) {
                                $cInfo['contractID'] = (int)$contractID;
                                $this->TaxContract->insert('tax_contract', $cInfo );
                                array_push($validID, $cInfo['contractID'] );
                            }
                        }
                        break;
                    }
                }
            }
        }
        $contract = implode( ',', $validID );
        $this->TaxContract->delete( 'tax_contract',
                                    'WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                 contractID NOT IN(' . addslashes( $contract ) . ')' );
    }
}
?>