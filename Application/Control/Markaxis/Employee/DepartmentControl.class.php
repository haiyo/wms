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
    public function getCountList( $data ) {
        if( isset( $data[1] ) && $data[1] == 'department' && isset( $data[2] ) ) {
            Control::setOutputArrayAppend( array( 'list' => $this->DepartmentModel->getCountList( $data[2] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveUser( ) {
        if( Control::hasPermission('Markaxis', 'add_modify_department' ) ) {
            $this->DepartmentModel->save( Control::getPostData( ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveDepartment( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_department' ) ) {
            $post = Control::getPostData( );
            $this->DepartmentModel->saveDepartment( $post );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>