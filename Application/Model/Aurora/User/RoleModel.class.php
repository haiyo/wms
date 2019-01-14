<?php
namespace Aurora\User;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: EmployeeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RoleModel extends \Model {


    // Properties


    /**
     * EmployeeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $roleID ) {
        File::import(DAO . 'Aurora/User/Role.class.php');
        $Role = new Role();
        return $Role->isFound( $roleID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        File::import(DAO . 'Aurora/User/Role.class.php');
        $Role = new Role();
        return $Role->getList( );
    }
}