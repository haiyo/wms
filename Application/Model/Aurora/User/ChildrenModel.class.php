<?php
namespace Aurora\User;
use \Library\IO\File;
use \Date, \Validator;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ChildrenModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChildrenModel extends \Model {


    // Properties


    /**
     * ChildrenModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByID( $userID, $ucID ) {
        File::import( DAO . 'Aurora/User/Children.class.php' );
        $Children = new Children( );
        return $Children->isFoundByID( $userID, $ucID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID ) {
        File::import( DAO . 'Aurora/User/Children.class.php' );
        $Children = new Children( );
        return $Children->getByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
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
        $validIDs = array( 0 );

        $ucInfo = array( );
        $ucInfo['userID'] = (int)$data['userID'];

        File::import( DAO . 'Aurora/User/Children.class.php' );
        $Children = new Children( );

        if( $size == 0 ) {
            // Delete any orphans if children = No
            $Children->delete( 'user_children', 'WHERE userID = "' . (int)$data['userID'] . '"' );
        }
        else {
            File::import( LIB . 'Util/Date.dll.php' );
            File::import( LIB . 'Validator/Validator.dll.php' );

            $saveInfo = array( );

            for( $i=0; $i<$size; $i++ ) {

                if( isset( $data['childName_' . $i] ) ) {
                    if( !$saveInfo['name'] = Validator::stripTrim( $data['childName_' . $i] ) )
                        continue;

                    File::import( MODEL . 'Aurora/Component/CountryModel.class.php' );
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
                        array_push( $validIDs, $Children->insert( 'user_children', $saveInfo ) );
                    }
                    else if( $this->isFoundByID( $data['userID'], $data['ucID_' . $i] ) ) {
                        $Children->update( 'user_children', $saveInfo, 'WHERE userID = "' . (int)$data['userID'] . '" 
                                                                            AND ucID = "' . (int)$data['ucID_' . $i] . '"' );

                        array_push($validIDs, $data['ucID_' . $i] );
                    }
                }
            }
            $validIDs = implode(',', $validIDs );
            $Children->delete('user_children', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                                            ucID NOT IN(' . addslashes( $validIDs ) . ')');
        }
    }
}
?>