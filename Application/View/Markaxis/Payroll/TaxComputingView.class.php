<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
use \Library\Util\Money;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxComputingView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxComputingView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TaxComputingModel;


    /**
    * TaxComputingView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/TaxRes');

        $this->TaxComputingModel = TaxComputingModel::getInstance( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderTaxRule( $taxRule ) {
        if( isset( $taxRule['trID'] ) && $computingInfo = $this->TaxComputingModel->getBytrID( $taxRule['trID'] ) ) {
            $criteriaSet = $age = $ordinary = $allPayItem = $workforce = array( );

            foreach( $computingInfo as $computing ) {
                if( $computing['criteria'] == 'age' ) {
                    $age[] = $computing;
                }
                if( $computing['criteria'] == 'ordinary' ) {
                    $ordinary[] = $computing;
                }
                if( $computing['criteria'] == 'allPayItem' ) {
                    $allPayItem[] = $computing;
                }
                if( $computing['criteria'] == 'workforce' ) {
                    $workforce[] = $computing;
                }
            }
            if( sizeof( $age ) == 1 ) {
                $txt = 'Employee age ';

                if( $age[0]['computing'] == 'gt' ) {
                    $txt .= 'more than ' . (float)$age[0]['value'];
                }
                if( $age[0]['computing'] == 'lt' ) {
                    $txt .= 'less than ' . (float)$age[0]['value'];
                }
                if( $age[0]['computing'] == 'lte' ) {
                    $txt .= (float)$age[0]['value'] . ' and below';
                }
                if( $age[0]['computing'] == 'eq' ) {
                    $txt .=  (float)$age[0]['value'];
                }
                array_push($criteriaSet, $txt );
            }
            // 2 Age Criteria
            if( sizeof( $age ) == 2 ) {
                if( $age[0]['value'] < $age[1]['value'] ) {
                    $txt  = 'Employee age from ';
                    $txt .= (float)$age[0]['value'] . ' to ' . (float)$age[1]['value'];
                    array_push($criteriaSet, $txt );
                }
                if( $age[0]['value'] > $age[1]['value'] ) {
                    $txt  = 'Employee age more than ';
                    $txt .= (float)$age[1]['value'] . ' to ' . (float)$age[0]['value'];
                    array_push($criteriaSet, $txt );
                }
            }

            $criteriaSet = $this->renderPayTags('Ordinary wage ', $ordinary, $criteriaSet, $taxRule );
            return $this->renderPayTags('All pay items ', $allPayItem, $criteriaSet, $taxRule );
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderPayTags( $typeText, $typeSet, $criteriaSet, $taxRule ) {
        $currency = $taxRule['currencyCode'] . $taxRule['currencySymbol'];

        if( sizeof( $typeSet ) == 1 ) {
            $txt = $typeText;

            if( $typeSet[0]['computing'] == 'gt' ) {
                $txt .= 'more than ' . $currency . Money::format( $typeSet[0]['value'] );
            }
            if( $typeSet[0]['computing'] == 'gte' ) {
                $txt .= 'not more than ' . $currency . Money::format( $typeSet[0]['value'] );
            }
            if( $typeSet[0]['computing'] == 'lt' ) {
                $txt .= 'less than ' . $currency . Money::format( $typeSet[0]['value'] );
            }
            if( $typeSet[0]['computing'] == 'lte' ) {
                $txt .= $currency . Money::format( $typeSet[0]['value'] ) . ' and below';
            }
            if( $typeSet[0]['computing'] == 'ltec' ) {
                $txt .= 'less than and capped at ' . $currency . Money::format( $typeSet[0]['value'] );
            }
            if( $typeSet[0]['computing'] == 'eq' ) {
                $txt .= $currency . Money::format( $typeSet[0]['value'] );
            }
            array_push($criteriaSet, $txt );
        }
        // 2 Salary Criteria
        if( sizeof( $typeSet ) == 2 ) {
            if( $typeSet[0]['value'] < $typeSet[1]['value'] ) {
                $txt  = $typeText . 'more than ';
                $txt .= $currency . Money::format( $typeSet[0]['value'] ) . ' to ' .
                        $currency . Money::format( $typeSet[1]['value'] );

                array_push($criteriaSet, $txt );
            }
            if( $typeSet[0]['value'] > $typeSet[1]['value'] ) {
                $txt  = $typeText . 'more than ';
                $txt .= $currency . Money::format( $typeSet[1]['value'] ) . ' to ' .
                        $currency . Money::format( $typeSet[0]['value'] );

                array_push($criteriaSet, $txt );
            }
        }
        return $criteriaSet;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderAll( $data ) {
        if( isset( $data['taxRules'] ) ) {
            foreach( $data['taxRules'] as $key => $taxRule ) {
                $data['taxRules'][$key]['computing'] = $this->renderTaxRule( $taxRule );
            }
            return $data;
        }
    }
}
?>