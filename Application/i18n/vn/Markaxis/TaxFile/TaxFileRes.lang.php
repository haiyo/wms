<?php
namespace Markaxis\TaxFile;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxFileRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxFileRes extends Resource {


    // Properties


    /**
     * PayrollRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_TAX_FILING'] = 'Tax Filing (IRAS)';
        $this->contents['LANG_CREATE_NEW_TAX_FILING'] = 'Create New Tax Filing';
        $this->contents['LANG_CREATE_AMENDMENT'] = 'Create Amendment';
        $this->contents['LANG_WHAT_IS_AIS'] = 'WHAT IS AUTO-INCLUSION SCHEME(AIS)?';
        $this->contents['LANG_IRAS_FORM'] = 'IRAS Form';
        $this->contents['LANG_SELECT_EMPLOYEE'] = 'Select Employee';
        $this->contents['LANG_DECLARATION_FOR_INDIVIDUAL_EMPLOYEE'] = 'Declaration For Individual Employee (Optional)';
        $this->contents['LANG_FILE_TAX_FOR_YEAR'] = 'File Tax For Year';
        $this->contents['LANG_SELECT_OFFICE'] = 'Select Office';
        $this->contents['LANG_SELECT_AUTHORIZED'] = 'Select Authorized Personnel';
        $this->contents['LANG_SELECT_SOURCE_TYPE'] = 'Select Source Type';
        $this->contents['LANG_ORGANISATION_ID_TYPE'] = 'Select Organisation ID Type';
        $this->contents['LANG_ORGANISATION_ID_NUMBER'] = 'Organisation ID Number';
        $this->contents['LANG_ORGANISATION_NAME'] = 'Organisation ID Name';
        $this->contents['LANG_SELECT_PAYMENT_TYPE'] = 'Type Of Payment';
        $this->contents['LANG_AUTHORISED_SUBMITTING_PERSONNEL'] = 'Authorised Submitting Personnel';
        $this->contents['LANG_FILE_BATCH_INDICATOR'] = 'File Batch Indicator';
        $this->contents['LANG_AUTHORISED_NAME'] = 'Authorised Personnel Name';
        $this->contents['LANG_DESIGNATION'] = 'Designation';
        $this->contents['LANG_IDENTITY_TYPE'] = 'Identity Type';
        $this->contents['LANG_IDENTITY_NUMBER'] = 'Identity Number';
        $this->contents['LANG_EMAIL'] = 'Email Address';
        $this->contents['LANG_CONTACT_NUMBER'] = 'Contact Number';
    }
}
?>