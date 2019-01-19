<?php
namespace Markaxis\Employee;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: EContactModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EContactModel extends \Model {


    // Properties
    protected $EContact;


    /**
     * EContactModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->EContact = new EContact( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $ecID ) {
        return $this->EContact->isFoundByUserID( $userID, $ecID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->EContact->getByUserID( $userID, $column );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        $preg = '/^ecID_\d{1,}/i';

        $callback = function( $val ) use( $preg ) {
            if( preg_match( $preg, $val, $match ) ) {
                return true;
            } else {
                return false;
            }
        };

        $ecID = array_filter( $data, $callback, ARRAY_FILTER_USE_KEY );
        $size = sizeof( $ecID );

        for( $i=0; $i<$size; $i++ ) {
            if( !$this->info['name'] = Validator::stripTrim( $data['eName_' . $i] ) ) {

                if( $this->isFoundByUserID( $data['userID'], $data['ecID_' . $i] ) ) {
                    $this->EContact->delete( 'employee_econtact', 'WHERE ecID = "' . (int)$data['ecID_' . $i] . '" AND
                                                                                userID = "' . (int)$data['userID'] . '"' );
                }
                continue;
            }
            $this->info['relationship'] = Validator::stripTrim( $data['eRs_' . $i] );
            $this->info['phone'] = Validator::stripTrim( $data['ePhone_' . $i] );
            $this->info['mobile'] = Validator::stripTrim( $data['eMobile_' . $i] );

            if( !$data['ecID_' . $i] || !$this->isFoundByUserID( $data['userID'], $data['ecID_' . $i] ) ) {
                $this->info['userID'] = (int)$data['userID'];
                $this->info['eID'] = (int)$data['eID'];
                $this->EContact->insert( 'employee_econtact', $this->info );
            }
            else {
                // Check permission if can update own or somebody else

                $this->EContact->update( 'employee_econtact', $this->info,
                                      'WHERE ecID = "' . (int)$data['ecID_' . $i] . '" AND 
                                                    userID = "' . (int)$data['userID'] . '"' );
            }
        }
    }
}
?>