<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CountryModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CountryModel extends \Model {


    // Properties
    protected $Country;


    /**
     * CountryModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Country = new Country( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        return $this->Country->isFound( $cID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBycID( $cID ) {
        return $this->Country->getBycID( $cID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Country->getList( );
    }
}
?>