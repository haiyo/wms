<?php
namespace Aurora\Form;
use \Aurora\Admin\AdminView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: YesNoRadioView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class YesNoRadioView extends AdminView {


    // Properties


    /**
    * YesNoRadioView Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Return Yes/No Radio Buttons
    * @return string
    */
    public static function build( $name, $value ) {
        $RadioView = new RadioView( );
        return $RadioView->build( $name, YesNoHelper::getL10nList( ), $value );
    }
}
?>