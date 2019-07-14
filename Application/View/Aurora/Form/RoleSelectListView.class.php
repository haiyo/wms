<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RoleSelectListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RoleSelectListView extends SelectListView {


    // Properties


    /**
    * RoleSelectListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Return Role List
    * @return string
    */
    public function getList( $roleList='', $withAdmin=false, $withHeader=false, $id='roles' ) {
        $Role = new Role( );
        $roles = $Role->getRoleList( );
        if( !$withAdmin ) unset( $roles[1] );
        if( $withHeader  ) {
            $roles[0] = $withHeader;
        }
        ksort($roles);
        return $this->build( $id, $roles, $roleList );
    }
}
?>