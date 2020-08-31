<?php
namespace Markaxis\Payroll;
use \Aurora\Component\CountryModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxRuleModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRuleModel extends \Model {


    // Properties
    protected $TaxRule;


    /**
     * TaxRuleModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/TaxRes');

        $this->TaxRule = new TaxRule( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID ) {
        return $this->TaxRule->isFound( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getAll( ) {
        return $this->TaxRule->getAll( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBytrID( $trID ) {
        return $this->TaxRule->getBytrID( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getProcessTaxRules( $data ) {
        if( isset( $data['taxGroups']['mainGroup'] ) ) {
            $tgIDs = array( );

            foreach( $data['taxGroups']['mainGroup'] as $mainGroup ) {
                $tgIDs[] = $mainGroup['tgID'];

                if( isset( $mainGroup['child'] ) && is_array( $mainGroup['child'] ) ) {
                    foreach( $mainGroup['child'] as $child ) {
                        if( isset( $child['tgID'] ) ) {
                            $tgIDs[] = $child['tgID'];
                        }
                    }
                }
            }
            $data['taxRules'] = $this->TaxRule->getBytgIDs( implode(', ', $tgIDs ) );
        }
        return $data;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function saveTaxRule( $data ) {
        $this->info['title'] = Validator::stripTrim( $data['ruleTitle'] );
        $this->info['tgID'] = (int)$data['group'];

        if( !$this->info['title'] ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_RULE_TITLE') );
            return false;
        }
        $CountryModel = CountryModel::getInstance( );
        if( $CountryModel->isFound( $data['country'] ) ) {
            $this->info['countryID'] = (int)$data['country'];
        }
        else {
            $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_COUNTRY') );
            return false;
        }
        if( $data['applyType'] == 'deductionOR' || $data['applyType'] == 'deductionAW' ||
            $data['applyType'] == 'contribution' || $data['applyType'] == 'skillLevy' ||
            $data['applyType'] == 'foreignLevy' ) {
            $this->info['applyType'] = $data['applyType'];
        }
        if( $data['applyValueType'] == 'percentage' || $data['applyValueType'] == 'fixed' ) {
            $this->info['applyValueType'] = $data['applyValueType'];
        }
        $this->info['applyValue'] = (float)$data['applyValue'];

        if( $this->info['tgID'] ) {
            $TaxGroupModel = new TaxGroupModel( );

            if( !$TaxGroupModel->isFound( $this->info['tgID'] ) ) {
                $this->info['tgID'] = 0;
            }
        }

        if( $data['trID'] && $this->isFound( $data['trID'] ) ) {
            $this->info['trID'] = (int)$data['trID'];
            $this->TaxRule->update( 'tax_rule', $this->info, 'WHERE trID = "' . (int)$this->info['trID'] . '"' );
        }
        else {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['trID'] = $this->TaxRule->insert('tax_rule', $this->info );
        }
        return $this->info['trID'];
    }


    /**
     * Delete Pay Item
     * @return mixed
     */
    public function deleteFromGroup( $groupList ) {
        if( is_array( $groupList ) ) {
            $groupList = implode(',', $groupList );

            $info = array( );
            $info['deleted'] = 1;
            $this->TaxRule->update('tax_rule', $info, 'WHERE tgID IN (' . addslashes( $groupList ) . ')' );
        }
    }


    /**
     * Delete Pay Item
     * @return mixed
     */
    public function delete( $trID ) {
        $info = array( );
        $info['deleted'] = 1;
        $this->TaxRule->update('tax_rule', $info, 'WHERE trID = "' . (int)$trID . '"' );
    }
}
?>