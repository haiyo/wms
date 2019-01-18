<?php
namespace Library\Helper\Aurora;
use \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: CurrencyHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CurrencyHelper implements IListHelper {


    // Properties


    /**
     * MaritalHelper Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Return List
     * @static
     * @return mixed
     */
    public static function getList( ) {
        return array( );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        return array('SGD$' => 'SGD$',
                    'USD$' => 'USD$',
                    'ARS$' => 'ARS$',
                    'AUD$' => 'AUD$',
                    'BSD$' => 'BSD$',
                    'BBD$' => 'BBD$',
                    'GYD$' => 'GYD$',
                    'BMD$' => 'BMD$',
                    'HKD$' => 'HKD$',
                    'FJD$' => 'FJD$',
                    'BND$' => 'BND$',
                    'CAD$' => 'CAD$',
                    'KYD$' => 'KYD$',
                    'CLP$' => 'CLP$',
                    'SVC$' => 'SVC$',
                    'COP$' => 'COP$',
                    'XCD$' => 'XCD$',
                    'EUR€' => 'EUR€',
                    'GBP£' => 'GBP£',
                    'EGP£' => 'EGP£',
                    'FKP£' => 'FKP£',
                    'GIP£' => 'GIP£',
                    'GGP£' => 'GGP£',
                    'IMP£' => 'IMP£',
                    'CNY¥' => 'CNY¥',
                    'BOB($b)' => 'BOB($b)',
                    'BZ$' => 'BZ$',
                    'Ft' => 'Ft',
                    'KM' => 'KM',
                    'HRK' => 'HRK',
                    'DKK' => 'DKK',
                    'ISK' => 'ISK',
                    'HNL' => 'HNL',
                    'ALL' => 'Lek',
                    'BWP' => 'BWP',
                    'BYR(p.)' => 'BYR(p.)',
                    'GTQ' => 'GTQ',
                    'BRL(R$)' => 'BRL(R$)',
                    'DOP(RD$)' => 'DOP(RD$)',
                    'INR(Rp)' => 'INR(Rp)',
                    'IDR(Rp)' => 'IDR(Rp)',
                    'AWG(ƒ)' => 'AWG(ƒ)',
                    'GHC(¢)' => 'GHC(¢)' );
    }
}
?>