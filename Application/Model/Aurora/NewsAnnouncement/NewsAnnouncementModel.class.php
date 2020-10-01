<?php
namespace Aurora\NewsAnnouncement;
use \Aurora\User\UserModel;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: NewsAnnouncementModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncementModel extends \Model {


    // Properties
    protected $NewsAnnouncement;


    /**
     * NewsAnnouncementModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->NewsAnnouncement = new NewsAnnouncement( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $naID ) {
        return $this->NewsAnnouncement->isFound( $naID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBynaID( $naID ) {
        return $this->NewsAnnouncement->getBynaID( $naID );
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

        $order = 'created';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'asc' ? ' asc' : ' desc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'title';
                    break;
                case 2:
                    $order = 'contentType';
                    break;
                case 3:
                    $order = 'name';
                    break;
                case 4:
                    $order = 'created';
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
     * Set Content Info
     * @return bool
     */
    public function isValid( $data ) {
        $Validator = new Validator( );

        $this->info['naID'] = (int)$data['naID'];
        $this->info['title'] = Validator::stripTrim( $data['naTitle'] );
        $this->info['content'] = Validator::stripTrimSelectedTags( $data['naContent'], array( 'script' ) );

        $Validator->addModule('contentType', new IsEmpty( $data['contentType'] ) );
        $Validator->addModule('title', new IsEmpty( $this->info['title'] ) );
        $Validator->addModule('content', new IsEmpty( $this->info['content'] ) );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $this->info['userID'] = $userInfo['userID'];
        $this->info['isNews'] = $data['contentType'] == 'news' ? 1 : 0;
        $this->info['created'] = date( 'Y-m-d H:i:s' );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }
        return true;
    }


    /**
     * Save Content information
     * @return int
     */
    public function save( ) {
        if( !$this->info['naID'] ) {
            unset( $this->info['naID'] );
            $this->info['naID'] = $this->NewsAnnouncement->insert( 'news_annoucement', $this->info );
        }
        else {
            $this->NewsAnnouncement->update( 'news_annoucement', $this->info, 'WHERE naID = "' . (int)$this->info['naID'] . '"' );
        }
        return $this->info['naID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $naID ) {
        if( $this->isFound( $naID ) ) {
            $this->NewsAnnouncement->delete( 'news_annoucement', 'WHERE naID = "' . (int)$naID . '"' );
        }
    }
}
?>