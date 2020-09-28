<?php
namespace Markaxis\Payroll;
use \Library\Util\Money;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxRuleWrapperModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRuleWrapperModel extends \Model {


    // Properties



    /**
     * TaxRuleWrapperModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/TaxRes');
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getAllTax( $trID ) {
        $TaxRuleWrapper = new TaxRuleWrapper( );
        return $TaxRuleWrapper->getAllTax( $trID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processTaxRules( $data ) {
        if( !isset( $data['taxRules'] ) || !isset( $data['items']['deduction'] ) ) {
            return $data;
        }

        $totalGross = $data['items']['totalOrdinary'];

        if( isset( $data['deductGross'] ) ) {
            foreach( $data['deductGross'] as $deduction ) {
                $totalGross -= $deduction;
            }
        }

        // Parse all passes to items
        foreach( $data['taxRules'] as $rules ) {
            $remark = '';
            $amount = 0;
            $ruleTitle = '';

            // Render taxgroup summary ruleTitle
            foreach( $data['taxGroups']['mainGroup'] as $taxGroup ) {
                // First find all the childs in this group and see if we have any summary=1
                if( isset( $taxGroup['child'] ) ) {
                    $tgIDChilds = array_unique( array_column( $taxGroup['child'],'tgID' ) );

                    if( isset( $rules['tgID'] ) && in_array( $rules['tgID'], $tgIDChilds ) ) {
                        foreach( $taxGroup['child'] as $child ) {
                            if( isset( $child['tgID'] ) && $child['tgID'] == $rules['tgID'] ) {
                                if( $child['summary'] ) {
                                    $ruleTitle = $child['title'];
                                    break 2;
                                }
                                else {
                                    $ruleTitle = $data['taxGroups']['mainGroup'][$child['parent']]['title'];
                                    break 2;
                                }
                            }
                        }
                    }
                }
                else if( $taxGroup['tgID'] == $rules['tgID'] ) {
                    $ruleTitle = $taxGroup['title'];
                    break;
                }
            }

            // Apply taxrules to totalGross and set itemRow
            if( $rules['applyType'] == 'deductionOR' && $rules['applyValue'] ) {
                if( $rules['applyValueType'] == 'percentage' ) {
                    if( isset( $rules['capped'] ) ) {
                        $amount = $rules['capped']*$rules['applyValue']/100;
                        $remark = '(Capped at ' . $data['office']['currencyCode'] .
                                                  $data['office']['currencySymbol'] . Money::format( $rules['capped'] ) . ')';
                    }
                    else {
                        $amount = $totalGross*$rules['applyValue']/100;
                        $remark = '';

                        if( $rules['applyCapped'] > 0 ) {
                            if( $amount > $rules['applyCapped'] ) {
                                $amount = $rules['applyCapped'];
                            }
                        }
                    }
                }
                if( $rules['applyValueType'] == 'fixed' ) {
                    $amount = $rules['applyValue'];
                    $remark = '';
                }
                $data['itemRow'][] = array( 'piID' => $data['items']['deduction']['piID'],
                                            'trID' => $rules['trID'],
                                            'tgID' => $rules['tgID'],
                                            'deduction' => 1,
                                            'title' => $ruleTitle,
                                            'amount' => $amount,
                                            'remark' => $remark );
            }

            if( $rules['applyType'] == 'contribution' && $rules['applyValueType'] ) {
                if( $rules['applyValueType'] == 'percentage' ) {
                    if( isset( $rules['capped'] ) ) {
                        $amount = $rules['capped']*$rules['applyValue']/100;
                        $remark = '(Capped at ' . $data['office']['currencyCode'] .
                                                  $data['office']['currencySymbol'] . Money::format( $rules['capped'] ) . ')';
                    }
                    else {
                        $amount = $totalGross*$rules['applyValue']/100;
                        $remark = '';
                    }
                }
                if( $rules['applyValueType'] == 'fixed' ) {
                    $amount = $rules['applyValue'];
                }
                $data['contribution'][$rules['trID']] = array( 'title' => $ruleTitle,
                                                               'trID' => $rules['trID'],
                                                               'amount' => $amount,
                                                               'remark' => $remark );
            }

            if( ( $rules['applyType'] == 'skillLevy' || $rules['applyType'] == 'foreignLevy' ) &&
                $rules['applyValueType'] ) {

                if ($rules['applyValueType'] == 'fixed') {
                    $amount = $rules['applyValue'];
                }
                if ($rules['applyValueType'] == 'percentage') {
                    $amount = $totalGross*$rules['applyValue'] / 100;
                }
                $data['levy'][] = array( 'title' => $ruleTitle,
                                         'amount' => $amount,
                                         'levyType' => $rules['applyType']);
            }
        }
        return $data;
    }
}
?>