<?php
namespace Markaxis\Team;
use \Aurora\User\UserModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TeamMemberModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TeamMemberModel extends \Model {


    // Properties
    protected $TeamMember;


    /**
     * TeamMemberModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->TeamMember = new TeamMember( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $tID ) {
        return $this->TeamMember->isFound( $tID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->TeamMember->isFoundByUserID( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getList( $q='' ) {
        $row = $this->Employee->getList( $q );

        if( sizeof( $row ) > 0 ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $row as $key => $value ) {
                $image = $UserImageModel->getImgLinkByUserID( $row[$key]['userID'] );
                $row[$key]['image'] = $image;
            }
        }
        return $row;
    }


    /**
     * Create New Team
     * @return mixed
     */
    public function create( $data ) {
        if( $data['tID'] && isset( $data['teamMembers'] ) ) {
            $userInfo = UserModel::getInstance( )->getInfo( );
            $members  = explode( ';', urldecode( $data['teamMembers'] ) );

            if( sizeof( $members ) > 0 ) {
                $UserModel = new UserModel( );

                foreach( $members as $value ) {
                    $name = Validator::stripTrim( $value );

                    if( $name && $memberInfo = $UserModel->getFieldByName( $name, 'userID' ) ) {
                        if( $memberInfo['userID'] != $userInfo['userID'] ) {
                            $this->info['tID'] = (int)$data['tID'];
                            $this->info['userID'] = (int)$userInfo['userID'];
                            $this->info['created'] = date( 'Y-m-d H:i:s' );
                            $this->TeamMember->insert( 'team_member', $this->info );
                        }
                    }
                }
            }
            // Enter for Admin
            $this->info['tID'] = (int)$data['tID'];
            $this->info['userID'] = (int)$userInfo['userID'];
            $this->info['isAdmin'] = 1;
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->TeamMember->insert( 'team_member', $this->info );
        }
    }
}
?>