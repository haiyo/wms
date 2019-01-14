<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Checkbox.dll.php, v 2.0 Exp $
 * @desc Build Checkboxes
*/

class Checkbox
{


    /**
    * Constructor
    * @returns void
    */
    function __construct( ) { }


    /**
    * Build Checkboxes
    * @returns str
    */
    public static function build( $name, $array, $selected='' ) {
    	$label = 1;
        $radio = '';
        foreach( $array as $key => $val ) {
            if( $key != '' ) {
                if( $selected && $key == $selected ) {
                    $select = ' checked="checked"';
                }
                else if( is_array( $selected ) && in_array( $key, $selected ) ) {
                    $select = ' checked="checked"';
    	        }
                else {
                    $select = '';
                }
    
                $radio .= '<input type="checkbox" id="' . $name . $label . '" name="' . $name . '" value="' . $key . '"' . $select . ' />
                           <label for="' . $name . $label . '">' . $val . "</label>\n";
            
                $label++;
            }    
        }
        return $radio;
    }
}
?>