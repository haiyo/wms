<?php
namespace Markaxis\Payroll;
use \Aurora\Component\CompetencyModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxCompetencyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxCompetencyModel extends \Model {


    // Properties
    protected $TaxCompetency;


    /**
     * TaxCompetencyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxCompetency = new TaxCompetency( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $cID ) {
        return $this->TaxCompetency->isFound( $trID, $cID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBytrID( $trID ) {
        return $this->TaxCompetency->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getBytrIDs( $trIDs ) {
        return $this->TaxCompetency->getBytrIDs( $trIDs );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getAll( $data ) {
        if( isset( $data['taxRules'] ) && is_array( $data['taxRules'] ) ) {
            foreach( $data['taxRules'] as $key => $taxRule ) {
                if( $cInfo = $this->getBytrID( $taxRule['trID'] ) ) {
                    $data['taxRules'][$key]['competency'] = $cInfo;
                }
            }
            return $data;
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getTaxRule( $taxRule ) {
        if( isset( $taxRule['trID'] ) ) {
            return $this->getBytrID( $taxRule['trID'] );
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $data ) {
        if( isset( $data['competency'] ) && isset( $data['taxRules'] ) && sizeof( $data['taxRules'] ) > 0 ) {
            $trIDs = implode(', ', array_column( $data['taxRules'], 'trID' ) );
            $competencies = $this->getBytrIDs( $trIDs );

            foreach( $competencies as $competency ) {
                if( !in_array( $competency['competency'], $data['competency'] ) ) {
                    unset( $data['taxRules'][$competency['trID']] );
                }
            }
        }
        return $data;
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
        $competencies = array( 0 );

        $cInfo = array();
        $cInfo['trID'] = (int)$data['trID'];

        if( isset( $data['competency'] ) && strlen( trim( $data['competency'] ) ) > 0 ) {
            $CompetencyModel = CompetencyModel::getInstance();
            $competencies = $CompetencyModel->save( $data['competency'] );
        }

        if( $sizeof > 0 ) {
            foreach( $criteria as $key => $value ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                    $id = $match[1];

                    switch ($data['criteria_' . $id]) {
                        case 'competency' :
                            if( is_array( $competencies ) ) {
                                foreach( $competencies as $cID ) {
                                    if( $cID && !$this->isFound($data['trID'], $cID ) ) {
                                        $cInfo['competency'] = (int)$cID;
                                        $this->TaxCompetency->insert('tax_competency', $cInfo);
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }
        $competency = implode(',', $competencies);
        $this->TaxCompetency->delete('tax_competency',
                                     'WHERE trID = "' . (int)$cInfo['trID'] . '" AND 
                                            competency NOT IN(' . addslashes($competency) . ')');
    }
}
?>