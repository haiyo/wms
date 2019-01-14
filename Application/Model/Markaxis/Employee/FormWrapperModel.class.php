<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: FormWrapperModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FormWrapperModel extends UserModel {


    // Properties



    /**
     * FormWrapperModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $post ) {
        //
    }
}
?>