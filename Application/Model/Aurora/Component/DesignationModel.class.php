<?php
namespace Aurora\Component;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: DesignationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationModel extends \Model {


    // Properties


    /**
     * DesignationModel Constructor
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
    public function isFound( $id ) {
        File::import( DAO . 'Aurora/Component/Designation.class.php' );
        $Designation = new Designation( );
        return $Designation->isFound( $id );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        File::import( DAO . 'Aurora/Component/Designation.class.php' );
        $Designation = new Designation( );
        return $this->info = $Designation->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getIDList( ) {
        File::import( DAO . 'Aurora/Component/Designation.class.php' );
        $Designation = new Designation( );
        return $this->info = $Designation->getIDList( );
    }
}
?>