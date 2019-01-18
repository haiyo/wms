<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PermissionModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PermissionModel extends \Model {


    // Properties


    /**
    * PermissionModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Return all permissions
    * @return mixed
    */
    public function getAll( ) {
        $Permission = new Permission( );
        return $Permission->getAll( );
    }
}
?>