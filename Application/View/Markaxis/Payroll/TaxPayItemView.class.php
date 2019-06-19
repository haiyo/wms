<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxPayItemView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxPayItemView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TaxPayItemModel;


    /**
    * TaxPayItemView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/TaxRes');

        $this->TaxPayItemModel = TaxPayItemModel::getInstance( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderTaxRule( $taxRule ) {
        /*if( isset( $taxRule['trID'] ) && $itemInfo = $this->TaxPayItemModel->getBytrID( $taxRule['trID'] ) ) {

            $criteriaSet = $age = $salary = $workforce = array( );
            $currency = $taxRule['currencyCode'] . $taxRule['currencySymbol'];

            foreach( $itemInfo as $item ) {
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
            if( sizeof( $salary ) == 1 ) {
                $txt = 'Employee salary ';

                if( $salary[0]['computing'] == 'gt' ) {
                    $txt .= 'more than ' . $currency . (float)$salary[0]['value'];
                }
                if( $salary[0]['computing'] == 'lt' ) {
                    $txt .= 'less than ' . $currency . (float)$salary[0]['value'];
                }
                if( $salary[0]['computing'] == 'lte' ) {
                    $txt .= $currency . (float)$salary[0]['value'] . ' and below';
                }
                if( $salary[0]['computing'] == 'eq' ) {
                    $txt .= $currency . (float)$salary[0]['value'];
                }
                array_push($criteriaSet, $txt );
            }
            // 2 Salary Criteria
            if( sizeof( $salary ) == 2 ) {
                if( $salary[0]['value'] < $salary[1]['value'] ) {
                    $txt  = 'Employee salary from ';
                    $txt .= $currency . (float)$salary[0]['value'] . ' to ' . $currency . (float)$salary[1]['value'];
                    array_push($criteriaSet, $txt );
                }
                if( $salary[0]['value'] > $salary[1]['value'] ) {
                    $txt  = 'Employee salary more than ';
                    $txt .= $currency . (float)$salary[1]['value'] . ' to ' . $currency . (float)$salary[0]['value'];
                    array_push($criteriaSet, $txt );
                }
            }
            return $criteriaSet;
        }*/
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderAll( $taxRules ) {
        /*foreach( $taxRules as $key => $taxRule ) {
            if( isset( $taxRule['trID'] ) && $itemInfo = $this->TaxPayItemModel->getBytrID( $taxRule['trID'] ) ) {
                $taxRules[$key]['payItem'] = $itemInfo;
            }
        }
        return $taxRules;*/
    }
}
?>