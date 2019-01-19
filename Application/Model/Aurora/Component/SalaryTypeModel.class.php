<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: SalaryTypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SalaryTypeModel extends \Model {


    // Properties
    protected $SalaryType;


    /**
     * SalaryTypeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->SalaryType = new SalaryType( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $stID ) {
        return $this->SalaryType->isFound( $stID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->SalaryType->getList( );
    }
}
?>