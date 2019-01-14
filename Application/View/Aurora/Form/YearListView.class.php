<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: YearListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class YearListView extends SelectListView {


    // Properties
    protected $startYear;
    protected $noBlank;


    /**
    * YearListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->startYear = 1980;
        $this->noBlank = false;
	}


    /**
    * Set starting year
    * @return void
    */
    function setStart( $start ) {
        $this->startYear = (int)$start;
	}


    /**
    * Set no blank value
    * @return void
    */
    function setnoBlank( ) {
        $this->noBlank = true;
	}


    /**
    * Reurn Year List
    * @return str
    */
    public function getList( $id, $year='' ) {
        $list = array( );
        if( !$this->noBlank ) $list[] = '';
        for( $i=$this->startYear; $i<=2099; $i++ ) {
            $list[$i] = $i;
        }
        return $this->build( $id, $list, $year );
    }
}
?>