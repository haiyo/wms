<?php
namespace Markaxis\Payroll;
use \Library\IO\File;

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
        File::import( DAO . 'Markaxis/Payroll/TaxRuleWrapper.class.php' );
        $TaxRuleWrapper = new TaxRuleWrapper( );
        return $TaxRuleWrapper->getAllTax( $trID );
    }
}
?>