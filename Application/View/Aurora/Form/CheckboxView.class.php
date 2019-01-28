<?php
namespace Aurora\Form;
use \Aurora\Admin\AdminView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CheckboxView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CheckboxView extends AdminView {


    // Properties
    protected $class;


    /**
    * CheckboxView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->class = false;
	}


    /**
    * Set Style
    * @return void
    */
    public function setClass( $class ) {
        $this->class = (string)$class;
    }


    /**
    * Build Checkbox
    * @return str
    */
    public function build( $name, $arrayList, $selected='' ) {
        $label = 1;
        $checkbox = array();
        foreach( $arrayList as $value => $key ) {
            if( $key != '' ) {
                if( $selected != '' && $value == $selected || $selected == 'all' ||
                    ( is_array( $selected ) && in_array( $key, $selected ) ) ) {
                    $select = ' checked="checked"';
                }
                else {
                    $select = '';
                }
                $checkbox[] = array( 'TPLVAR_CHECKBOX_ID'     => $name . $label,
                                     'TPLVAR_CHECKBOX_NAME'   => $name,
                                     'TPLVAR_CHECKBOX_VALUE'  => $value,
                                     'TPLVAR_CHECKBOX_KEY'    => $key,
                                     'TPLVAR_CHECKBOX_SELECT' => $select,
                                     'TPLVAR_CHECKBOX_CLASS'  => $this->class );
                $label++;
            }
        }
        return $this->parseTPL( $checkbox );
    }


    /**
    * Parse Checkbox Template
    * @return str
    */
    private function parseTPL( $checkbox ) {
        $vars['dynamic']['checkbox'] = $checkbox;
        return $this->render( 'aurora/form/checkbox.tpl', $vars );
    }
}
?>