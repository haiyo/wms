<?php
namespace Aurora\Form;
use \Aurora\AuroraView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RadioView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RadioView extends AuroraView {


    // Properties


    /**
    * RadioView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Build Radio Buttons
    * @return str
    */
    public function build( $name, $arrayList, $selected='', $class='' ) {
        $label = 1;
        $radio = array();
        foreach( $arrayList as $value => $key ) {
            if( $key != '' ) {
                if( $selected !== '' && $value == $selected ) {
                    $select = ' checked="checked"';
                }
                else {
                    $select = '';
                }
                $radio[] = array( 'TPLVAR_RADIO_ID'     => $name . $label,
                                  'TPLVAR_RADIO_NAME'   => $name,
                                  'TPLVAR_RADIO_VALUE'  => $value,
                                  'TPLVAR_RADIO_KEY'    => $key,
                                  'TPLVAR_RADIO_SELECT' => $select,
                                  'TPLVAR_CLASS'        => $class );
                $label++;
            }
        }
        return $this->parseTPL( $radio );
    }


    /**
    * Parse Radio Buttons Template
    * @return str
    */
    private function parseTPL( $radio ) {
        $vars['dynamic']['radio'] = $radio;
        return $this->render( 'aurora/form/radio.tpl', $vars );
    }
}
?>