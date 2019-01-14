<?php
namespace Markaxis\Employee;
use \Library\IO\File;
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
     * @return str
     */
    public function save( ) {
        File::import( MODEL . 'Markaxis/Employee/EContactModel.class.php' );
        $EContactModel = EContactModel::getInstance( );
        $EContactModel->save( Control::getPostData( ) );
    }
}
?>