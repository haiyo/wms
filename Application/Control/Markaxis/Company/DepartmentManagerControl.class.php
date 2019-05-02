<?php
namespace Markaxis\Company;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: DepartmentManagerControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentManagerControl {


    // Properties
    private $DepartmentManagerModel;


    /**
     * DepartmentManagerControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->DepartmentManagerModel = DepartmentManagerModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveDepartment( ) {
        $post = Control::getPostData( );

        if( $this->DepartmentManagerModel->isValid( $post ) ) {
            $post['dID'] = $this->DepartmentManagerModel->save( );
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->DepartmentManagerModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string

    public function deleteDepartment( ) {
        $oID = Control::getRequest( )->request( POST, 'data' );

        $this->DepartmentModel->delete( $oID );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    } */
}
?>