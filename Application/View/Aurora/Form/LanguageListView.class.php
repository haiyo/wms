<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LanguageListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LanguageListView extends SelectListView {


    // Properties


    /**
    * LanguageListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Return Language List
    * @return str
    */
    public function getList( ) {
        return $this->build( 'language', $this->i18n->getLanguages( ),
                             '?lang=' . $this->i18n->getUserLang( ) );
    }
}
?>