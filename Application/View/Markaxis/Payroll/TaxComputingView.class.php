<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxComputingView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxComputingView extends AdminView {


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
        parent::__construct( );

        $this->Registry = Registry::getInstance();
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

            $criteriaSet = $age = $salary = $workforce = array( );
            $currency = $taxRule['currencyCode'] . $taxRule['currencySymbol'];

            foreach( $computingInfo as $computing ) {
                if( $computing['criteria'] == 'age' ) {
                    $age[] = $computing;
                }
                if( $computing['criteria'] == 'salary' ) {
                    $salary[] = $computing;
                }
                if( $computing['criteria'] == 'workforce' ) {
                    $workforce[] = $computing;
                }
            }

            if( sizeof( $age ) == 1 ) {
                $txt = 'Employee age ';

                if( $age[0]['computing'] == 'gt' ) {
                    $txt .= 'more than ' . $age[0]['value'];
                }
                if( $age[0]['computing'] == 'lt' ) {
                    $txt .= 'less than ' . $age[0]['value'];
                }
                if( $age[0]['computing'] == 'eq' ) {
                    $txt .=  $age[0]['value'];
                }
                array_push($criteriaSet, $txt );
            }

            if( sizeof( $age ) == 2 ) {
                if( $age[0]['value'] < $age[1]['value'] ) {
                    $txt  = 'Employee age from ';
                    $txt .= $age[0]['value'] . ' to ' . $age[1]['value'];
                    array_push($criteriaSet, $txt );
                }
            }

            if( sizeof( $salary ) == 1 ) {
                $txt = 'Employee salary ';

                if( $salary[0]['computing'] == 'gt' ) {
                    $txt .= 'more than ' . $currency . $salary[0]['value'];
                }
                if( $salary[0]['computing'] == 'lt' ) {
                    $txt .= 'less than ' . $currency . $salary[0]['value'];
                }
                if( $salary[0]['computing'] == 'eq' ) {
                    $txt .= $currency . $salary[0]['value'];
                }
                array_push($criteriaSet, $txt );
            }

            if( sizeof( $salary ) == 2 ) {
                if( $salary[0]['value'] < $salary[1]['value'] ) {
                    $txt  = 'Employee salary from ';
                    $txt .= $currency . $salary[0]['value'] . ' to ' . $currency . $salary[1]['value'];
                    array_push($criteriaSet, $txt );
                }
            }
            return $criteriaSet;
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderAll( $taxRules ) {
        foreach( $taxRules as $key => $taxRule ) {
            $taxRules[$key]['computing'] = $this->renderTaxRule( $taxRule );
        }
        return $taxRules;
    }
}
?>