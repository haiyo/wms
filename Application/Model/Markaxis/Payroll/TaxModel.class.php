<?php
namespace Markaxis\Payroll;
use \Aurora\Component\OfficeModel, \Aurora\Component\StateModel, \Aurora\Component\CityModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxModel extends \Model {


    // Properties
    protected $Tax;


    /**
     * TaxModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/TaxRes');

        $this->Tax = new Tax( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID ) {
        return $this->Tax->isFound( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByGroupID( $tgID ) {
        return $this->Tax->isFoundByGroupID( $tgID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getParentList( ) {
        return $this->Tax->getParentList( );
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
        $OfficeModel = OfficeModel::getInstance( );
        if( $OfficeModel->isFound( $data['office'] ) ) {
            $this->info['office'] = (int)$data['office'];
        }
        $StateModel = StateModel::getInstance( );
        if( isset( $data['state'] ) && $StateModel->isFound( $data['state'] ) ) {
            $this->info['state'] = (int)$data['state'];
        }
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

        if( $this->info['tgID'] && !$this->isFoundByGroupID( $this->info['tgID'] ) ) {
            $this->info['tgID'] = 0;
        }

        if( $data['trID'] && $this->isFound( $data['trID'] ) ) {
            $this->info['trID'] = (int)$data['trID'];
            $this->Tax->update( 'tax_rule', $this->info, 'WHERE trID = "' . (int)$this->info['trID'] . '"' );
        }
        else {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['trID'] = $this->Tax->insert('tax_rule', $this->info );
        }
        return $this->info['trID'];
    }
}
?>