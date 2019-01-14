<?php
namespace Aurora\Page;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: MenuModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MenuModel extends \Model {


    // Properties


    /**
     * MenuModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Retrieve menu information
     * @return mixed
     */
    public function getMenu( ) {
        File::import( DAO . 'Aurora/Page/Menu.class.php' );
        $Menu = new Menu( );
        return $Menu->getMenu( );
    }
}
?>