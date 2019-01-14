<?php
namespace Markaxis\Payroll;
use \Aurora\Component\CountryModel, \Aurora\Component\StateModel, \Aurora\Component\CityModel;
use \Library\IO\File;
use \Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxRuleModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRuleModel extends \Model {


    // Properties



    /**
     * TaxRuleModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/TaxRes');
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID ) {
        File::import( DAO . 'Markaxis/Payroll/TaxRule.class.php' );
        $TaxRule = new TaxRule( );
        return $TaxRule->isFound( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getAll( ) {
        File::import( DAO . 'Markaxis/Payroll/TaxRule.class.php' );
        $TaxRule = new TaxRule( );
        return $TaxRule->getAll( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBytrID( $trID ) {
        File::import( DAO . 'Markaxis/Payroll/TaxRule.class.php' );
        $TaxRule = new TaxRule( );
        return $TaxRule->getBytrID( $trID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function saveTaxRule( $data ) {
        File::import(LIB . 'Validator/Validator.dll.php');

        $this->info['title'] = Validator::stripTrim( $data['ruleTitle'] );
        $this->info['tgID'] = (int)$data['group'];

        if( !$this->info['title'] ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_RULE_TITLE') );
            return false;
        }

        File::import( MODEL . 'Aurora/Component/CountryModel.class.php' );
        $CountryModel = CountryModel::getInstance( );
        if( $CountryModel->isFound( $data['country'] ) ) {
            $this->info['country'] = (int)$data['country'];
        }

        File::import( MODEL . 'Aurora/Component/StateModel.class.php' );
        $StateModel = StateModel::getInstance( );
        if( isset( $data['state'] ) && $StateModel->isFound( $data['state'] ) ) {
            $this->info['state'] = (int)$data['state'];
        }

        File::import( MODEL . 'Aurora/Component/CityModel.class.php' );
        $CityModel = CityModel::getInstance( );
        if( isset( $data['city'] ) && $CityModel->isFound( $data['city'] ) ) {
            $this->info['city'] = (int)$data['city'];
        }

        if( $data['applyType'] == 'salaryDeduction' || $data['applyType'] == 'employerContribution' ||
            $data['applyType'] == 'employerLevy' ) {
            $this->info['applyType'] = $data['applyType'];
        }

        if( $data['applyValueType'] == 'percentage' || $data['applyValueType'] == 'fixed' ) {
            $this->info['applyValueType'] = $data['applyValueType'];
        }

        $this->info['applyValue'] = (int)$data['applyValue'];

        if( $this->info['tgID'] ) {
            File::import( MODEL . 'Markaxis/Payroll/TaxGroupModel.class.php' );
            $TaxGroupModel = new TaxGroupModel( );

            if( !$TaxGroupModel->isFound( $this->info['tgID'] ) ) {
                $this->info['tgID'] = 0;
            }
        }

        File::import( DAO . 'Markaxis/Payroll/TaxRule.class.php' );
        $TaxRule = new TaxRule( );

        if( $data['trID'] && $this->isFound( $data['trID'] ) ) {
            $this->info['trID'] = (int)$data['trID'];
            $TaxRule->update( 'tax_rule', $this->info, 'WHERE trID = "' . (int)$this->info['trID'] . '"' );
        }
        else {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['trID'] = $TaxRule->insert('tax_rule', $this->info );
        }
        return $this->info['trID'];
    }
}
?>