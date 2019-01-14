<?php
namespace Markaxis\Company;
use \Library\IO\File;

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

        File::import( DAO . 'Markaxis/Company/CompanyType.class.php' );
        $this->CompanyType = new CompanyType( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function getList( ) {
        return $this->CompanyType->getList( );
    }
}
?>