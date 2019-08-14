<?php
namespace Markaxis\Leave;
use \Aurora\Component\ContractModel AS A_ContractModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ContractModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContractModel extends \Model {


    // Properties
    protected $Contract;



    /**
     * ContractModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Contract = new Contract( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $lgID, $cID ) {
        return $this->Contract->isFound( $lgID, $cID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByID( $lgID, $cID ) {
        return $this->Contract->getByID( $lgID, $cID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getBylgID( $lgID ) {
        return $this->Contract->getBylgID( $lgID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByGroups( $leaveTypes ) {
        foreach( $leaveTypes as $key => $type ) {
            if( sizeof( $type['group'] ) > 0 ) {
                foreach( $type['group'] as $groupKey => $group ) {
                    $leaveTypes[$key]['group'][$groupKey]['contract'] = $this->Contract->getBylgID( $group['lgID'] );
                }
            }
        }
        return $leaveTypes;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['leaveGroups'] ) && is_array( $data['leaveGroups'] ) ) {
            $ContractModel = A_ContractModel::getInstance( );

            $success = array( );

            foreach( $data['leaveGroups'] as $groupObj ) {
                if( isset( $groupObj->contractType ) && is_array( $groupObj->contractType ) && sizeof( $groupObj->contractType ) > 0 ) {
                    foreach( $groupObj->contractType as $contractID ) {
                        if( $ContractModel->isFound( $contractID ) ) {
                            if( !$lcInfo = $this->getByID( $groupObj->lgID, $contractID ) ) {
                                $info = array( );
                                $info['lgID'] = $groupObj->lgID;
                                $info['cID'] = $contractID;
                                array_push($success, $this->Contract->insert( 'leave_contract', $info ) );
                            }
                            else {
                                array_push($success, $lcInfo['lcID'] );
                            }
                        }
                    }
                }
                else {
                    $this->Contract->delete('leave_contract', 'WHERE lgID = "' . (int)$groupObj->lgID . '"');
                }
            }
            if( sizeof( $success ) > 0 ) {
                $this->Contract->delete('leave_contract', 'WHERE lcID NOT IN(' . implode(',', $success) . ') 
                                                                 AND lgID = "' . (int)$groupObj->lgID . '"');
            }
        }
    }
}
?>