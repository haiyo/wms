<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PermListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PermListView extends RadioView {


    // Properties


    /**
    * PermListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Build Radio Buttons
    * @return str
    */
    public function getList( $name, $selected='' ) {
        return $this->build( $name, PermHelper::getL10nList( ), $selected );
    }
}
?>