<?php
namespace Markaxis\Team;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TeamModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TeamModel extends \Model {


    // Properties
    protected $Team;


    /**
     * TeamModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->info['name'] = $this->info['description'] = '';
        $this->Team = new Team( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $tID ) {
        return $this->Team->isFound( $tID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->Team->isFoundByUserID( $userID );
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
        $this->info['name'] = Validator::stripTrim( $data['teamName'] );
        $this->info['description'] = Validator::stripTrim( $data['teamDescript'] );

        if( $this->info['name'] ) {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            return $this->Team->insert('team', $this->info);
        }
        return false;
    }
}
?>