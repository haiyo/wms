<?php
namespace Markaxis\Calendar;
use Aurora\AuroraView;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LabelListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LabelListView extends AdminView {


    // Properties


    /**
    * LabelListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}
    
    
    /**
    * Build Select List
    * @return str
    */
    public function getList( $name, $arrayList, $selected='' ) {
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Calendar/Helper/LabelRes');

        $vars   = array( 'TPLVAR_NAME' => $name,
                         'LANG_MANAGE_LABEL' => $L10n->getContents('LANG_MANAGE_LABEL') );
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
        return $this->render( 'markaxis/calendar/html/labelList.tpl', $vars );
    }
}
?>