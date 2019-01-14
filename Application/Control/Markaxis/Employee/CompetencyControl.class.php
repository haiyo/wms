<?php
namespace Markaxis\Employee;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CompetencyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyControl {


    // Properties


    /**
     * CompetencyControl Constructor
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
        $post = Control::getPostData( );

        File::import( MODEL . 'Markaxis/Employee/CompetencyModel.class.php' );
        $CompetencyModel = CompetencyModel::getInstance( );
        $CompetencyModel->save( $post );
    }
}
?>