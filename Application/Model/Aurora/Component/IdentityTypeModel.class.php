<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: IdentityTypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IdentityTypeModel extends \Model {


    // Properties
    protected $IdentityType;


    /**
     * IdentityTypeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->IdentityType = new IdentityType( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $nID ) {
        return $this->IdentityType->isFound( $nID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->IdentityType->getList( );
    }
}
?>