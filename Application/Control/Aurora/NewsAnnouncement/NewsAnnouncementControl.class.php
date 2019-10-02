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
        Control::setOutputArrayAppend( array( 'sidebarCards' => $this->NewsAnnouncementView->renderNewsAnnouncement( ) ) );
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
}
?>