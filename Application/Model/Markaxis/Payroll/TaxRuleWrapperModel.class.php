<?php
namespace Markaxis\Payroll;

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
        if( !isset( $data['taxRules'] ) || !isset( $data['deduction'] ) ) {
            return $data;
        }
        // Parse all passes to items
        foreach( $data['taxRules'] as $rules ) {

            if( $rules['applyType'] == 'deductionOR' && $rules['applyValue'] && isset( $data['totalOrdinary'] ) ) {
                if( $rules['applyValueType'] == 'percentage' ) {
                    if( isset( $rules['capped'] ) ) {
                        $amount = $rules['capped']*$rules['applyValue']/100;
                        $remark = ' (Capped at ' . $data['empInfo']['currency'] .
                                    number_format( $rules['capped'] ) . ')';
                    }
                    else {
                        $amount = $data['totalOrdinary']*$rules['applyValue']/100;
                        $remark = '';
                    }
                }
                if( $rules['applyValueType'] == 'fixed' ) {
                    $amount = $rules['applyValue'];
                    $remark = '';
                }
                $data['items'][] = array( 'piID' => $data['deduction']['piID'],
                                          'trID' => $rules['trID'],
                                          'tgID' => $rules['tgID'],
                                          'deduction' => 1,
                                          'remark' => $rules['title'] . $remark,
                                          'amount' => $amount );
            }

            if( $rules['applyType'] == 'skillLevy' && $rules['applyValueType'] ) {
                if( $rules['applyValueType'] == 'fixed' ) {
                    $amount = $rules['applyValue'];
                }
                if( $rules['applyValueType'] == 'percentage' ) {
                    $amount = $data['empInfo']['salary']*$rules['applyValue']/100;
                }
                $data['skillLevy'] = array( 'title' => $rules['title'],
                                            'amount' => $amount );
            }

            if( $rules['applyType'] == 'foreignLevy' && $rules['applyValueType'] ) {
                if( $rules['applyValueType'] == 'fixed' ) {
                    $amount = $rules['applyValue'];
                }
                $data['foreignLevy'] = array( 'title' => $rules['title'],
                                              'amount' => $amount );
            }

            if( $rules['applyType'] == 'contribution' && $rules['applyValueType'] ) {
                if( $rules['applyValueType'] == 'percentage' ) {
                    if( isset( $rules['capped'] ) ) {
                        $amount = $rules['capped']*$rules['applyValue']/100;
                    }
                    else {
                        $amount = $data['empInfo']['salary']*$rules['applyValue']/100;
                    }
                }
                if( $rules['applyValueType'] == 'fixed' ) {
                    $amount = $rules['applyValue'];
                }
                $data['contribution'][$rules['trID']] = array( 'title' => $rules['title'],
                                                               'trID' => $rules['trID'],
                                                               'amount' => $amount );
            }
        }
        return $data;
    }
}
?>