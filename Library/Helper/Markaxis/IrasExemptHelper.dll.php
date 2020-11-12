<?php
namespace Library\Helper\Markaxis;
use \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: IrasExemptHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IrasExemptHelper implements IListHelper {


    // Properties


    /**
     * IrasExemptHelper Constructor
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
        return array( 1, 3, 4, 5, 6, 7 );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        return array(
            1 => 'Tax Remission on Overseas Cost of Living Allowance (OCLA)',
            3 => 'Seaman',
            4 => 'Exemption',
            5 => 'Overseas Pension Fund with Tax Concession',
            6 => 'Income from Overseas Employment',
            7 => 'Income from Overseas Employment and Overseas Pension Fund with Tax Concession'
        );
    }
}
?>