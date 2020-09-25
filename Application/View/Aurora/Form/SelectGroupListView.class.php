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
    private $sortEnable = true;


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
    public function enableSort( $bool ) {
        $this->sortEnable = $bool;
    }


    /**
     * Build Select List
     * @return string
     */
    public function build( $name, $arrayList, $selected='', $placeHolder='', $id=true ) {
        $list = '';
        $size = sizeof( $arrayList );
        $parent = array( );

        if( $this->sortEnable ) {
            $sort = false;
            usort($arrayList, function($a, $b) {
                return $a['parent'] <=> $b['parent'];
            });
        }

        for( $i=0; $i<$size; $i++ ) {
            // First find whether this parent has any children, if not skip!
            if( isset( $arrayList[$i]['parent'] ) && $arrayList[$i]['parent'] == 0 ) {
                if( !array_search( $arrayList[$i]['id'], array_column( $arrayList, 'parent') ) ) {
                    continue;
                }

                $parent[$arrayList[$i]['id']]['label'] = $arrayList[$i]['title'];
                continue;
            }

            // Children
            if( isset( $parent[$arrayList[$i]['parent']] ) ) {
                if( $this->sortEnable && !$sort ) {
                    asort($parent );
                    $sort = true;
                }

                $select = '';

                if( $selected != '' && $selected == $arrayList[$i]['id'] || $selected == 'all' ||
                    ( is_array( $selected ) && in_array( $arrayList[$i], $selected ) ) ) {
                    $select = ' selected="selected"';
                }
                $parent[$arrayList[$i]['parent']]['child'][] = array( 'TPLVAR_VALUE'  => $arrayList[$i]['id'],
                                                                      'TPLVAR_TITLE'  => $arrayList[$i]['title'],
                                                                      'TPLVAR_CLASS'  => isset( $arrayList[$i]['class'] ) ? $arrayList[$i]['class'] : '',
                                                                      'TPLVAR_SELECT' => $select );
            }
        }

        if( sizeof( $parent ) > 0 ) {
            foreach( $parent as $value ) {
                $vars = array( );
                $vars['TPLVAR_LABEL'] = $value['label'];

                foreach( $value['child'] as $child ) {
                    $vars['dynamic']['option'][] = $child;
                }
                $list .= $this->View->render( 'aurora/form/optGroupList.tpl', $vars );
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
        $vars['TPL_GROUP_LIST'] = $list;
        return $this->View->render( 'aurora/form/groupList.tpl', $vars );

    }
}
?>