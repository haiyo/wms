<?php
namespace Aurora\Component;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CityModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CityModel extends \Model {


    // Properties


    /**
     * CityModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        File::import( DAO . 'Aurora/Component/City.class.php' );
        $City = new City( );
        return $City->isFound( $cID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( $data ) {
        if( isset( $data['state'] ) ) {
            File::import(DAO . 'Aurora/Component/City.class.php');
            $City = new City( );
            return $City->getList( $data['state']  );
        }
        return false;
    }
}
?>