<?php
namespace Aurora\User;
use \Aurora\Component\CountryModel;
use \Library\Validator\Validator, \Library\Util\Date;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ChildrenModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChildrenModel extends \Model {


    // Properties
    protected $Children;


    /**
     * StructureModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Children = new Children( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByID( $userID, $ucID ) {
        return $this->Children->isFoundByID( $userID, $ucID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID ) {
        return $this->Children->getByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getYoungestByUserID( $userID ) {
        return $this->Children->getYoungestByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
        if( $data['children'] == 0 ) {
            $this->deleteAll( $data['userID'] );
            return;
        }

        $preg = '/^ucID_(\d)+/';

        $callback = function( $val ) use( $preg ) {
            if( preg_match( $preg, $val,$match ) ) {
                return true;
            } else {
                return false;
            }
        };

        $child = array_filter( $data, $callback,ARRAY_FILTER_USE_KEY );
        $size = sizeof( $child );
        $validIDs = array( );

        $ucInfo = array( );
        $ucInfo['userID'] = (int)$data['userID'];

        if( $size == 0 ) {
            // Delete any orphans if no children
            $this->deleteAll( $ucInfo['userID'] );
        }
        else {
            $saveInfo = array( );

            for( $i=0; $i<$size; $i++ ) {

                if( isset( $data['childName_' . $i] ) ) {
                    if( !$saveInfo['name'] = Validator::stripTrim( $data['childName_' . $i] ) )
                        continue;

                    $CountryModel = CountryModel::getInstance( );
                    if( $CountryModel->isFound( $data['childCountry_' . $i] ) ) {
                        $saveInfo['country'] = (int)$data['childCountry_' . $i];
                    }
                    else {
                        continue;
                    }

                    if( !$saveInfo['birthday'] = Date::getDateStr( $data['childDobMonth_' . $i], $data['childDobDay_' . $i], $data['childDobYear_' . $i] ) ) {
                        continue;
                    }

                    if( !$data['ucID_' . $i] ) {
                        $saveInfo['userID'] = $data['userID'];
                        array_push( $validIDs, $this->Children->insert( 'user_children', $saveInfo ) );
                    }
                    else if( $this->isFoundByID( $data['userID'], $data['ucID_' . $i] ) ) {
                        $this->Children->update( 'user_children', $saveInfo, 'WHERE userID = "' . (int)$data['userID'] . '" 
                                                                            AND ucID = "' . (int)$data['ucID_' . $i] . '"' );

                        array_push($validIDs, $data['ucID_' . $i] );
                    }
                }
            }

            $User = new User( );

            if( sizeof( $validIDs ) > 0 ) {
                $validIDs = implode(',', $validIDs );
                $this->Children->delete('user_children','WHERE userID = "' . (int)$data['userID'] . '" AND 
                                                            ucID NOT IN(' . addslashes( $validIDs ) . ')');

                $User->update( 'user', array( 'children' => 1 ), 'WHERE userID = "' . (int)$data['userID'] . '"' );
            }
            else {
                $User->update( 'user', array( 'children' => 0 ), 'WHERE userID = "' . (int)$data['userID'] . '"' );
            }
        }
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function deleteAll( $userID ) {
        $this->Children->delete('user_children','WHERE userID = "' . (int)$userID . '"' );
    }
}
?>