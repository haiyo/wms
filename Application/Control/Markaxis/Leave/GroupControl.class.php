<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: GroupControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GroupControl {


    // Properties
    protected $GroupModel;
    protected $GroupView;


    /**
     * GroupControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->GroupModel = GroupModel::getInstance( );
        $this->GroupView = new GroupView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getGroup( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['lgID'] ) ) {
            Control::setOutputArray( array( 'group' => $this->GroupModel->getByID( $post['lgID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function editType( $args ) {
        $ltID = isset( $args[1] ) ? (int)$args[1] : 0;

        //Control::setOutputArrayAppend( array( 'form' => $this->GroupView->renderEditType( $ltID ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveType( ) {
        $post = Control::getPostData( );
        $post = $this->GroupModel->save( $post );
        Control::setPostData( $post );
    }
}
?>