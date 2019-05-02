<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: DepartmentControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentControl {


    // Properties
    private $DepartmentModel;


    /**
     * DepartmentControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->DepartmentModel = DepartmentModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $this->DepartmentModel->save( Control::getPostData( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveDepartment( ) {
        $post = Control::getPostData( );
        $this->DepartmentModel->saveDepartment( $post );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>