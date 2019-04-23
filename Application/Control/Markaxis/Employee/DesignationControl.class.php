<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: DesignationControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationControl {


    // Properties
    private $DesignationModel;
    private $DesignationView;


    /**
     * DesignationControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->DesignationModel = DesignationModel::getInstance( );
        $this->DesignationView = new DesignationView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->DesignationView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getDesignationResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->DesignationModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveDesignation( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

        if( $this->DesignationModel->isValid( $post ) ) {
            $this->DesignationModel->save( );
            $vars['bool'] = 1;
            if( $post['group'] ) {
                $vars['groupListUpdate'] = $this->DesignationView->renderGroupList( );
            }
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->DesignationModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteDesignation( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

        if( $vars['count'] = $this->DesignationModel->delete( $post ) ) {
            $vars['bool'] = 1;
            if( $post['group'] ) {
                $vars['groupListUpdate'] = $this->DesignationView->renderGroupList( );
            }
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->DesignationModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteOrphanGroups( ) {
        $vars['bool'] = 1;
        $vars['count'] = $this->DesignationModel->deleteOrphanGroups( );
        $vars['groupListUpdate'] = $this->DesignationView->renderGroupList( );
        echo json_encode( $vars );
        exit;
    }
}
?>