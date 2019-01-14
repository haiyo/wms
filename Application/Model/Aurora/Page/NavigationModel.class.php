<?php
namespace Aurora\Page;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: NavigationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NavigationModel extends \Model {


    // Properties


    /**
    * NavigationModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Retrieve a Page Information
    * @return mixed
    */
    public function getMenu( ) {
        File::import( DAO . 'Aurora/Page.class.php' );
        $Menu = new Menu( );
        return $Menu->getMenuInfo( );
    }
}
?>