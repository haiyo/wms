<?php
namespace Markaxis\Calendar;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LabelListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LabelListView {


    // Properties


    /**
    * LabelListView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
	}
    
    
    /**
    * Build Select List
    * @return string
    */
    public function getList( $name, $arrayList, $selected='' ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Helper/LabelRes');

        $vars   = array( 'TPLVAR_NAME' => $name );
        $option = array( );

        foreach( $arrayList as $row ) {
            $select = '';
            if( $selected != '' ) {
                if( $selected == $row['color'] ) {
                	$select = ' selected="selected"';
    	        }
                else if( is_array( $selected ) && in_array( $row['color'], $selected ) ) {
                	$select = ' selected="selected"';
    	        }
            }
            $option[] = array( 'TPLVAR_COLOR'  => $row['color'],
                               'TPLVAR_LABEL'  => $row['label'],
                               'TPLVAR_SELECT' => $select );
        }
        $vars['dynamic']['option'] = $option;
        return $this->View->render( 'markaxis/calendar/labelList.tpl', $vars );
    }
}
?>