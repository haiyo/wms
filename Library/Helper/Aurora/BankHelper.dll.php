<?php
namespace Library\Helper\Aurora;
use \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: BankHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BankHelper implements IListHelper {


    // Properties


    /**
     * BankHelper Constructor
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
        return array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
                      'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V' );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        return array( 1 => 'DBS BANK LTD',
                      2 => 'UNITED OVERSEAS BANK LIMITED',
                      3 => 'OVERSEA-CHINESE BANKING CORPORATION LIMITED',
                      5 => 'CIMB BANK BERHAD',
                      6 => 'CITIBANK SINGAPORE LIMITED',
                      7 => 'THE HONGKONG AND SHANGHAI BANKING CORPORATION LIMITED',
                      8 => 'MALAYAN BANKING BERHAD',
                      9 => 'STANDARD CHARTERED BANK',
                     'A' => 'FAR EASTERN BANK LTD',
                     'B' => 'AUSTRALIA & NEW ZEALAND BANKING GROUP LIMITED',
                     'C' => 'BANGKOK BANK PUBLIC COMPANY LIMITED',
                     'D' => 'BANK OF AMERICA, NATIONAL ASSOCIATION',
                     'E' => 'BANK OF CHINA LIMITED',
                     'F' => 'BANK OF EAST ASIA LTD',
                     'G' => 'BANK OF INDIA',
                     'H' => 'BANK OF TOKYO-MITSUBISHI UFJ, LTD',
                     'I' => 'BNP PARIBAS',
                     'J' => 'CREDIT AGRICOLE CORPORATE AND INVESTMENT BANK',
                     'K' => 'HL BANK',
                     'L' => 'ICICI BANK LIMITED',
                     'M' => 'INDIAN BANK',
                     'N' => 'INDIAN OVERSEAS BANK',
                     'O' => 'INDUSTRIAL AND COMMERCIAL BANK OF CHINA LIMITED',
                     'P' => 'JPMORGAN CHASE BANK, N.A.',
                     'Q' => 'MIZUHO CORPORATE BANK LTD',
                     'R' => 'PT BANK NEGARA INDONESIA (PERSERO) TBK',
                     'S' => 'RHB BANK BERHAD',
                     'T' => 'STATE BANK OF INDIA',
                     'U' => 'SUMITOMO MITSUI BANKING CORPORATION',
                     'V' => 'UCO BANK',
                      4 => 'OTHERS' );
    }
}
?>