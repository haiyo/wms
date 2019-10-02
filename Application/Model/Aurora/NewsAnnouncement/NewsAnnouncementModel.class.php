<?php
namespace Aurora\NewsAnnouncement;
use \Aurora\User\UserModel;
use \Library\Interfaces\IObservable, \Library\Helper\HTMLHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: NewsAnnouncementModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncementModel extends \Model {


    // Properties
    protected $NewsAnnouncement;
    protected $userInfo;


    /**
     * NewsAnnouncementModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->NewsAnnouncement = new NewsAnnouncement( );
        $this->userInfo = UserModel::getInstance( )->getInfo( );
    }


    /**
     * Return list by userID
     * @return mixed
     */
    public function getList( ) {
        $this->NewsAnnouncement->setLimit( 0, 3 );
        return $this->NewsAnnouncement->getList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->NewsAnnouncement->setLimit( $post['start'], $post['length'] );

        $order = 'title';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'title';
                    break;
                case 2:
                    $order = 'name';
                    break;
                case 3:
                    $order = 'd.title';
                    break;
                case 4:
                    $order = 'e.email1';
                    break;
                case 5:
                    $order = 'u.mobile';
                    break;
                case 6:
                    $order = 'u.suspended';
                    break;
            }
        }
        $results = $this->NewsAnnouncement->getResults( $post['search']['value'], $order . $dir );
        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Add new notification
     * @return int
     */
    public function create( ) {
        $info = array( );
        $info['message'] = $this->info['message'];
        $info['url'] = $this->info['url'];
        $info['created'] = $this->info['created'];

        $HTMLHelper = new HTMLHelper( );
        $vars = array( );
        $vars['TPLVAR_FNAME'] = $this->userInfo['fname'];
        $vars['TPLVAR_LNAME'] = $this->userInfo['lname'];
        $info['message'] = $HTMLHelper->parseTemplate( $this->info['message'], $vars );
        $nID = $this->Notification->insert( 'notification', $info );

        if( is_array( $this->info['toUserID'] ) ) {
            foreach( $this->info['toUserID'] as $toUserID ) {
                $info = array( );
                $info['nID'] = (int)$nID;
                $info['userID'] = (int)$this->info['userID'];
                $info['toUserID'] = (int)$toUserID;
                $this->Notification->insert( 'notification_user', $info );
            }
        }
    }
}
?>