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


    /**
     * DepartmentControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function view( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        //
    }


    /**
     * Render main navigation
     * @return str

    public function save( ) {
        $post = Control::getPostData( );

        $DepartmentModel = DepartmentModel::getInstance( );
        $DepartmentModel->save( $post );
    } */
}
?>