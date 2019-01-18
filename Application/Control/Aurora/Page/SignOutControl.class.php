<?php
namespace Aurora\Page;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: SignOutControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SignOutControl {


    // Properties


    /**
    * SignOutControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Render main navigation
    * @return str
    */
    public function getMainMenu( ) {
        $SignOutView = new SignOutView( );
        return $SignOutView->getMainMenu( );
    }
}
?>