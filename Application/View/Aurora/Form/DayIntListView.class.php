<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DayIntListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DayIntListView extends SelectListView {


    // Properties


    /**
    * DayIntListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Reurn Day List
    * @return str
    */
    public function getList( $id, $day='', $placeHolder='' ) {
        $list = array( );
        for( $i=01; $i<=31; $i++ ) {
            $list[$i] = $i;
        }
        return $this->build( $id, $list, $day, $placeHolder );
    }
}
?>