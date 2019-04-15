<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserListView extends SelectListView {


    // Properties


    /**
    * UserListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Reurn Year List
    * @return string
    */
    public function getList( $userList ) {
        $User = new User( );
        $user = $User->getUserList( );
        return $this->build( 'users', $user, $userList );
    }
}
?>