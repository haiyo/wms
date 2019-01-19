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
     * @return int
     */
    public function getBytrID( $trID ) {
        return $this->TaxContract->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getAll( $taxRules ) {
        if( is_array( $taxRules ) && sizeof( $taxRules ) > 0 ) {
            foreach( $taxRules as $key => $taxRule ) {
                if( $cInfo = $this->getBytrID( $taxRule['trID'] ) ) {
                    $taxRules[$key]['contract'] = $cInfo;
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

        $cInfo = array( );
        $cInfo['trID'] = (int)$data['trID'];

        if( $sizeof > 0 ) {
            foreach( $criteria as $key => $value ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                    $id = $match[1];

                    switch( $data['criteria_' . $id] ) {
                        case 'contract' :
                            $ContractModel = ContractModel::getInstance( );

                            // Check if base table exist or not first.
                            if( $ContractModel->isFound( $data['contract_' . $id] ) ) {
                                $cInfo['contract'] = $data['contract_' . $id];

                                if( $data['contractID_' . $id] ) {
                                    if( $ctInfo = $this->getByID( $cInfo['trID'], $data['contractID_' . $id] ) ) {
                                        $this->TaxContract->update('tax_contract', $cInfo,
                                            'WHERE tcID = "' . (int)$data['contractID_' . $id] . '"' );

                                        array_push($validID, $data['contractID_' . $id] );
                                    }
                                } else {
                                    array_push($validID, $this->TaxContract->insert('tax_contract', $cInfo ) );
                                }
                            }
                            break;
                    }
                }
            }
        }
        $contract = implode( ',', $validID );
        $this->TaxContract->delete( 'tax_contract','WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                                        tcID NOT IN(' . addslashes( $contract ) . ')' );
    }
}
?>