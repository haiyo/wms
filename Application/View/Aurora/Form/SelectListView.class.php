<?php
namespace Aurora\Form;
use \Aurora\Admin\AdminView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: SelectListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SelectListView extends AdminView {


    // Properties
    protected $multiple;
    protected $disabled;
    protected $includeBlank;
    protected $class;


    /**
    * SelectListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->multiple = false;
        $this->disabled = false;
        $this->includeBlank = true;
	}


    /**
     * Set Multiple List
     * @return void
     */
    public function setClass( $class ) {
        $this->class = $class;
    }
    
    
    /**
    * Set Multiple List
    * @return void
    */
    public function isMultiple( $bool ) {
        $this->multiple = $bool ? true : false;
    }


    /**
     * Set Multiple List
     * @return void
     */
    public function isDisabled( $bool ) {
        $this->disabled = $bool ? true : false;
    }


    /**
     * Set Multiple List
     * @return void
     */
    public function includeBlank( $bool ) {
        $this->includeBlank = $bool ? true : false;
    }


    /**
    * Build Select List
    * @return string
    */
    public function build( $name, $arrayList, $selected='', $placeHolder='', $id=true ) {

        $vars = array( 'TPLVAR_NAME' => $name,
                       'TPLVAR_PLACEHOLDER' => $placeHolder,
                       'TPLVAR_CLASS'  => $this->class, );

        $vars['dynamic']['multiple'] = false;
        $vars['dynamic']['disabled'] = false;
        $vars['dynamic']['option']   = false;
        $vars['dynamic']['id'] = false;

        if( $id ) {
            $vars['dynamic']['id'][] = array( 'TPLVAR_ID' => $name );
        }

        if( $this->multiple ) {
            $vars['TPLVAR_NAME'] = $vars['TPLVAR_NAME'] . '[]';
            $vars['dynamic']['multiple'][] = array( 'TPLVAR_MULTIPLE' => $this->multiple );
        }

        if( $this->disabled ) {
            $vars['dynamic']['disabled'] = true;
        }

        if( $this->includeBlank ) {
            $vars['dynamic']['option'][] = array( 'TPLVAR_VALUE'  => '',
                                                  'TPLVAR_SELECT' => '',
                                                  'TPLVAR_KEY'    => '' );
        }
        foreach( $arrayList as $key => $value ) {
            $select = '';
            if( $selected != '' ) {
                if( $selected == $key || $selected == 'all' ||
                    ( is_array( $selected ) && in_array( $key, $selected ) ) ) {
                    $select = ' selected="selected"';
                }
            }
            $vars['dynamic']['option'][] = array( 'TPLVAR_VALUE'  => $value,
                                                  'TPLVAR_SELECT' => $select,
                                                  'TPLVAR_KEY'    => $key );
        }
        return $this->render( 'aurora/form/selectList.tpl', $vars );
    }
}
?>