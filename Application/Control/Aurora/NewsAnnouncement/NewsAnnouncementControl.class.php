<?php
namespace Aurora\NewsAnnouncement;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NewsAnnouncementControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncementControl {


    // Properties
    private $NewsAnnouncementModel;
    private $NewsAnnouncementView;


    /**
     * NewsAnnouncementControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->NewsAnnouncementModel = NewsAnnouncementModel::getInstance( );
        $this->NewsAnnouncementView = new NewsAnnouncementView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArrayAppend( $this->NewsAnnouncementView->renderNewsAnnouncement( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getContent( $data ) {
        $vars = array( );
        $naID = isset( $data[1] ) ? $data[1] : $data;

        if( $naID && $info = $this->NewsAnnouncementModel->getBynaID( $naID ) ) {
            $vars['data'] = $info;
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 1;
            $vars['errMsg'] = $this->NewsAnnouncementModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return void
     */
    public function list( ) {
        $this->NewsAnnouncementView->renderList( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function results( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->NewsAnnouncementModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        if( Control::hasPermission( 'Aurora', 'add_modify_news' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

            if( $this->NewsAnnouncementModel->isValid( $post ) ) {
                $this->NewsAnnouncementModel->save( );
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->NewsAnnouncementModel->getErrMsg( );
            }
            echo json_encode( $vars );
            exit;
        }
    }
}
?>