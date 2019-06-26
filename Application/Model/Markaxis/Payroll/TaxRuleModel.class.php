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
        if( $data['taxGroups'] ) {
            $tgIDs = implode(', ', array_column( $data['taxGroups'], 'tgID' ) );
            return $this->TaxRule->getBytgIDs( $tgIDs );
        }
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
            $data['applyType'] == 'contribution' || $data['applyType'] == 'levy' ) {
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
}
?>