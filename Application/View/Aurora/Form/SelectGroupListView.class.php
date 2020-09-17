<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: SelectGroupListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SelectGroupListView extends SelectListView {


    // Properties


    /**
     * SelectGroupListView Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Build Select List
     * @return string
     */
    public function build( $name, $arrayList, $selected='', $placeHolder='', $id=true ) {
        $list = '';
        $size = sizeof( $arrayList );
        $isParsed = false;
        $parent = $vars = array( );

        for( $i=0; $i<$size; $i++ ) {
            if( isset( $arrayList[$i]['parent'] ) && $arrayList[$i]['parent'] == 0 ) {
                if( $isParsed ) {
                    $list .= $this->View->render( 'aurora/form/optGroupList.tpl', $vars );
                    $vars = array( );
                }
                $vars['TPLVAR_LABEL'] = $arrayList[$i]['title'];
                $parent[$arrayList[$i]['id']] = true;
            }
            else if( isset( $parent[$arrayList[$i]['parent']] ) ) {
                $select = '';
                if( $selected != '' ) {
                    if( $selected == $arrayList[$i]['id'] || $selected == 'all' ||
                        ( is_array( $selected ) && in_array( $arrayList[$i], $selected ) ) ) {
                        $select = ' selected="selected"';
                    }
                }
                $vars['dynamic']['option'][] = array( 'TPLVAR_VALUE'  => $arrayList[$i]['id'],
                                                      'TPLVAR_TITLE'  => $arrayList[$i]['title'],
                                                      'TPLVAR_CLASS'  => isset( $arrayList[$i]['class'] ) ? $arrayList[$i]['class'] : '',
                                                      'TPLVAR_SELECT' => $select );
                $isParsed = true;

                if( $i == ($size-1) ) {
                    $list .= $this->View->render( 'aurora/form/optGroupList.tpl', $vars );
                }
            }
        }

        $vars = array( 'TPLVAR_NAME' => $name,
                       'TPLVAR_PLACEHOLDER' => $placeHolder,
                       'TPLVAR_CLASS' => $this->class );

        $vars['dynamic']['multiple'] = false;
        $vars['dynamic']['disabled'] = false;
        $vars['dynamic']['blank'] = false;
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
            $vars['dynamic']['blank'] = true;
        }
        if( !$isParsed ) {
            $vars['dynamic']['option'] = false;
        }
        $vars['TPL_GROUP_LIST'] = $list;
        return $this->View->render( 'aurora/form/groupList.tpl', $vars );

    }
}
?>