<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CityModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CityModel extends \Model {


    // Properties
    protected $City;


    /**
     * CityModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->City = new City( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        return $this->City->isFound( $cID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( $data ) {
        if( isset( $data['state'] ) ) {
            return $this->City->getList( $data['state']  );
        }
        return false;
    }
}
?>