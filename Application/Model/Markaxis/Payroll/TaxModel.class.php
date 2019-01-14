<?php
namespace Markaxis\Payroll;
use \Aurora\Component\CountryModel, \Aurora\Component\StateModel, \Aurora\Component\CityModel;
use \Library\IO\File;
use \Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxModel extends \Model {


    // Properties



    /**
     * TaxModel Constructor
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
        File::import( DAO . 'Markaxis/Payroll/Tax.class.php' );
        $Tax = new Tax( );
        return $Tax->isFound( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByGroupID( $tgID ) {
        File::import( DAO . 'Markaxis/Payroll/Tax.class.php' );
        $Tax = new Tax( );
        return $Tax->isFoundByGroupID( $tgID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getParentList( ) {
        File::import( DAO . 'Markaxis/Payroll/Tax.class.php' );
        $Tax = new Tax( );
        return $Tax->getParentList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function saveTaxGroup( $data ) {
        File::import(LIB . 'Validator/Validator.dll.php');

        $this->info['title'] = Validator::stripTrim( $data['groupTitle'] );
        $this->info['description'] = Validator::stripTrim( $data['description'] );
        $this->info['parent'] = (int)$data['parent'];

        if( $this->info['parent'] && !$this->isFoundByGroupID( $this->info['parent'] ) ) {
            $this->info['parent'] = 0;
        }

        File::import( DAO . 'Markaxis/Payroll/Tax.class.php' );
        $Tax = new Tax( );

        if( $data['tgID'] && $this->isFoundByGroupID( $data['tgID'] ) ) {
            $this->info['tgID'] = (int)$data['tgID'];
            $Tax->update( 'tax_group', $this->info, 'WHERE tgID = "' . (int)$this->info['tgID'] . '"' );
        }
        else {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['tgID'] = $Tax->insert('tax_group', $this->info );
        }
        return $this->info['tgID'];
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

        if( $data['applyType'] == 'deduction' || $data['applyType'] == 'contribution' || $data['applyType'] == 'levy' ) {
            $this->info['applyType'] = $data['applyType'];
        }

        if( $data['applyValueType'] == 'percentage' || $data['applyValueType'] == 'fixed' ) {
            $this->info['applyValueType'] = $data['applyValueType'];
        }

        $this->info['applyValue'] = (int)$data['applyValue'];

        File::import( DAO . 'Markaxis/Payroll/Tax.class.php' );
        $Tax = new Tax( );

        if( $this->info['tgID'] && !$this->isFoundByGroupID( $this->info['tgID'] ) ) {
            $this->info['tgID'] = 0;
        }

        if( $data['trID'] && $this->isFound( $data['trID'] ) ) {
            $this->info['trID'] = (int)$data['trID'];
            $Tax->update( 'tax_rule', $this->info, 'WHERE trID = "' . (int)$this->info['trID'] . '"' );
        }
        else {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['trID'] = $Tax->insert('tax_rule', $this->info );
        }
        return $this->info['trID'];
    }
}
?>