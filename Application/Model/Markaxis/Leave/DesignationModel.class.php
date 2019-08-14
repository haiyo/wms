<?php
namespace Markaxis\Leave;
use \Aurora\Component\DesignationModel AS A_Designation;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: DesignationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationModel extends \Model {


    // Properties
    protected $Designation;



    /**
     * DesignationModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Designation = new Designation( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->Designation->isFound( $ltID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getBylgID( $lgID ) {
        return $this->Designation->getBylgID( $lgID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByGroups( $leaveTypes ) {
        foreach( $leaveTypes as $key => $type ) {
            if( sizeof( $type['group'] ) > 0 ) {
                foreach( $type['group'] as $groupKey => $group ) {
                    $leaveTypes[$key]['group'][$groupKey]['designation'] = $this->Designation->getBylgID( $group['lgID'] );
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
            $DesignationModel = A_Designation::getInstance( );

            $success = array( );

            foreach( $data['leaveGroups'] as $groupObj ) {
                if( isset( $groupObj->designation ) && is_array( $groupObj->designation ) && sizeof( $groupObj->designation ) > 0 ) {
                    foreach( $groupObj->designation as $designation ) {
                        if( $DesignationModel->isFound( $designation ) ) {
                            $info = array( );
                            $info['lgID'] = $groupObj->lgID;
                            $info['dID'] = $designation;
                            array_push( $success, $this->Designation->insert( 'leave_designation', $info ) );
                        }
                    }
                }
                else {
                    $this->Designation->delete('leave_designation', 'WHERE lgID = "' . (int)$groupObj->lgID . '"');
                }
            }
            if( sizeof( $success ) > 0 ) {
                $this->Designation->delete('leave_designation', 'WHERE ldID NOT IN(' . implode(',', $success) . ') 
                                                                                AND lgID = "' . (int)$groupObj->lgID . '"');
            }
        }
    }
}
?>