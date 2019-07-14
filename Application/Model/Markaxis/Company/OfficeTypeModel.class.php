<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: OfficeTypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeTypeModel extends \Model {


    // Properties
    protected $OfficeType;


    /**
    * OfficeTypeModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->OfficeType = new OfficeType( );
	}


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $otID ) {
        return $this->OfficeType->isFound( $otID );
    }


    /**
    * Return total count of records
    * @return int
    */
    public function getList( ) {
        return $this->OfficeType->getList( );
    }
}
?>