<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: CompanyTypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyTypeModel extends \Model {


    // Properties
    protected $CompanyType;


    /**
    * CompanyTypeModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->CompanyType = new CompanyType( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function getList( ) {
        if( !$this->info ) {
            $this->info = $this->CompanyType->getList( );
        }
        return $this->info;
    }
}
?>