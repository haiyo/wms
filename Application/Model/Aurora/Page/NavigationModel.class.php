<?php
namespace Aurora\Page;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: NavigationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NavigationModel extends \Model {


    // Properties
    protected $Menu;


    /**
    * NavigationModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Menu = new Menu( );
    }


    /**
    * Retrieve a Page Information
    * @return mixed
    */
    public function getMenu( ) {
        return $this->Menu->getMenuInfo( );
    }
}
?>