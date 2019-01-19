<?php
namespace Aurora\Form;
use \Aurora\AuroraView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ONOFFRadioView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ONOFFRadioView extends AuroraView {


    // Properties


    /**
    * ONOFFRadioView Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Return ON/OFF Radio Buttons
    * @return str
    */
    public static function build( $name, $value ) {
        $RadioView = new RadioView( );
        return $RadioView->build( $name, OnOffHelper::getL10nList( ), $value );
    }
}
?>