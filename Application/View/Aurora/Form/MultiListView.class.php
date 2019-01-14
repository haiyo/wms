<?php
namespace Aurora\Form;
use \Aurora\AuroraView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: MultiListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MultiListView extends AuroraView {


    // Properties
    protected $class;


    /**
    * MultiListView Constructor
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
    * Build Multi List
    * @return str
    */
    public function build( $name, $arrayList, $selected='' ) {
        $vars = array( 'TPLVAR_NAME'  => $name,
                       'TPLVAR_CLASS' => $this->class );
        $label = 1;
        $option = array( );
        foreach( $arrayList as $value => $key ) {
            $select = '';
            if( $selected != '' ) {
                if( $selected == $value ) {
                	$select = ' checked="checked"';
    	        }
                else if( is_array( $selected ) && in_array( $value, $selected ) ) {
                	$select = ' checked="checked"';
    	        }
            }
            $option[] = array( 'TPLVAR_LIST_ID' => $name . $label,
                               'TPLVAR_VALUE'   => $value,
                               'TPLVAR_SELECT'  => $select,
                               'TPLVAR_KEY'     => $key );
            $label++;
        }
        $vars['dynamic']['list'] = $option;
        return $this->render( 'aurora/form/multiList.tpl', $vars );
    }
}
?>