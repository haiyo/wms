<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EContactControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EContactControl {


    // Properties


    /**
     * EContactControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $EContactModel = EContactModel::getInstance( );
        $EContactModel->save( Control::getPostData( ) );
    }
}
?>