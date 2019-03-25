<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: NationalityModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NationalityModel extends \Model {


    // Properties
    protected $Country;


    /**
     * NationalityModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Nationality = new Nationality( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $nID ) {
        return $this->Nationality->isFound( $nID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Nationality->getList( );
    }
}
?>