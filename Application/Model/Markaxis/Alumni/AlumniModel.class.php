<?php
namespace Markaxis\Alumni;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: AlumniModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AlumniModel extends \Model {


    // Properties



    /**
     * AlumniModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        //$this->L10n = $i18n->loadLanguage('Aurora/UserRes');
    }
}
?>