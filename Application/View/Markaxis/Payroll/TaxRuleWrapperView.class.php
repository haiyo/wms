<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView, \Library\Helper\Aurora\GenderHelper;
use \Aurora\Component\RaceModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxRuleWrapperView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRuleWrapperView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TaxWrapperModel;


    /**
    * TaxRuleWrapperView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/TaxRes');

        $this->TaxRuleWrapperModel = TaxRuleWrapperModel::getInstance( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderTaxRule( $taxRule ) {
        if( isset( $taxRule['trID'] ) ) {
            if( $taxRule['applyValueType'] == 'percentage' ) {
                $applyAs = (float)$taxRule['applyValue'] . '% ';
            }
            else { // Fixed
                $applyAs = $taxRule['currencyCode'] . $taxRule['currencySymbol'] . (float)$taxRule['applyValue'] . ' ';
            }

            $badge = '';

            if( $taxRule['applyType'] == 'deductionOR' ) {
                $applyAs .= $this->L10n->getContents('LANG_DEDUCTION_FROM_ORDINARY_WAGE');
                $badge = 'success';
            }
            else if( $taxRule['applyType'] == 'deductionAW' ) {
                $applyAs .= $this->L10n->getContents('LANG_DEDUCTION_FROM_ADDITIONAL_WAGE');
                $badge = 'warning';
            }
            else if( $taxRule['applyType'] == 'contribution' ) {
                $applyAs .= $this->L10n->getContents('LANG_EMPLOYER_CONTRIBUTION');
                $badge = 'warning';
            }
            else if( $taxRule['applyType'] == 'levy' ) {
                $applyAs .= $this->L10n->getContents('LANG_EMPLOYER_LEVY');
                $badge = 'warning';
            }

            $vars = array_merge( $this->L10n->getContents( ),
                    array( 'TPLVAR_TRID' => $taxRule['trID'],
                           'TPLVAR_RULE_TITLE' => $taxRule['title'],
                           'TPLVAR_GID' => $taxRule['tgID'],
                           'TPLVAR_APPLY_AS' => $applyAs,
                           'TPLVAR_BADGE' => $badge ) );

            $vars['dynamic']['criteria'] = false;

            if( isset( $taxRule['computing'] ) ) {
                foreach( $taxRule['computing'] as $criteria ) {
                    $vars['dynamic']['criteria'][] = array( 'TPLVAR_CRITERIA' => $criteria );
                }
            }
            if( isset( $taxRule['competency'] ) ) {
                foreach( $taxRule['competency'] as $criteria ) {
                    $vars['dynamic']['criteria'][] = array( 'TPLVAR_CRITERIA' => $criteria['competency'] );
                }
            }
            if( isset( $taxRule['contract'] ) ) {
                foreach( $taxRule['contract'] as $contract ) {
                    $vars['dynamic']['criteria'][] = array( 'TPLVAR_CRITERIA' => $contract['type'] );
                }
            }
            if( isset( $taxRule['designation'] ) ) {
                foreach( $taxRule['designation'] as $designation ) {
                    $vars['dynamic']['criteria'][] = array( 'TPLVAR_CRITERIA' => $designation['title'] );
                }
            }
            if( isset( $taxRule['race'] ) ) {
                //$RaceModel = RaceModel::getInstance( );
                //$raceList = $RaceModel->getList( );

                foreach( $taxRule['race'] as $race ) {
                    $vars['dynamic']['criteria'][] = array( 'TPLVAR_CRITERIA' => $race );
                }
            }
            if( isset( $taxRule['gender'] ) ) {
                foreach( $taxRule['gender'] as $gender ) {
                    $gender = GenderHelper::getL10nList( )[$gender['gender']];
                    $vars['dynamic']['criteria'][] = array( 'TPLVAR_CRITERIA' => $gender );
                }
            }
            return $this->render( 'markaxis/payroll/taxRule.tpl', $vars );
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderAll( $taxRules ) {
        $html = '';

        foreach( $taxRules as $taxRule ) {
            $html .= $this->renderTaxRule( $taxRule );
        }
        return $html;
    }
}
?>