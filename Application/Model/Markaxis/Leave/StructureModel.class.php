<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\EmployeeModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: StructureModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StructureModel extends \Model {


    // Properties
    protected $Structure;


    /**
     * StructureModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Structure = new Structure( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByGroup( $lgID ) {
        return $this->Structure->isFoundByGroup( $lgID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBylgID( $lgID ) {
        $structureInfo = $this->Structure->getBylgID( $lgID );

        if( $structureInfo ) {
            foreach( $structureInfo as $key => $structure ) {
                $structureInfo[$key]['days'] = (float)$structure['days'];
            }
        }
        return $structureInfo;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBydesignationID( $ldID ) {
        return $this->Structure->getBydesignationID( $ldID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByGroups( $leaveTypes ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        if( sizeof( $empInfo ) > 0 ) {
            $months = $EmployeeModel->getCurrYearWorkMonth( );

            foreach( $leaveTypes as $key => $type ) {
                if( sizeof( $type['group'] ) > 0 ) {
                    foreach( $type['group'] as $group ) {

                        if( ( isset( $group['designation'] ) && isset( $empInfo['designationID'] ) &&
                              isset( $group['designation'][$empInfo['designationID']] ) && sizeof( $group['designation'] ) > 0 ) ||
                            ( isset( $group['contract'] ) && isset( $empInfo['contractID'] ) &&
                                isset( $group['contract'][$empInfo['contractID']] ) && sizeof( $group['contract'] ) > 0 ) ) {

                            if( $group['proRated'] && $group['entitledLeaves'] ) {
                                $leaveTypes[$key]['totalLeaves'] = round($months/12*$group['entitledLeaves'] );
                            }
                            else {
                                $structures = $this->Structure->getBylgID( $group['lgID'] );

                                if( sizeof( $structures ) > 0 ) {
                                    // Reverse order structure to check from the max first.
                                    $structures = array_reverse( $structures );

                                    foreach( $structures as $structure ) {
                                        if( ( $structure['start'] <= $months ) && ( $months <= $structure['end'] ) ) {
                                            $leaveTypes[$key]['totalLeaves'] = $structure['days'];
                                        }
                                    }
                                }
                            }
                        }
                    }
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
            foreach( $data['leaveGroups'] as $groupObj ) {
                if( $groupObj->proRated == 1 ) {
                    $this->Structure->delete('leave_structure', 'WHERE lgID = "' . (int)$data['lgID'] . '"');
                }
                else if( isset( $groupObj->structures ) && is_array( $groupObj->structures ) && sizeof( $groupObj->structures ) > 0 ) {
                    $success = array( );

                    foreach( $groupObj->structures as $structure ) {
                        if( isset( $structure->start ) && isset( $structure->end ) && isset( $structure->days ) &&
                            is_numeric( $structure->start ) && is_numeric( $structure->end ) && is_numeric( $structure->days ) ) {
                            $info = array( );
                            $info['lgID'] = $groupObj->lgID;
                            $info['start'] = (int)$structure->start;
                            $info['end'] = (int)$structure->end;
                            $info['days'] = (int)$structure->days;
                            array_push( $success, $this->Structure->insert( 'leave_structure', $info ) );
                        }
                    }
                    if( sizeof( $success ) > 0 ) {
                        $this->Structure->delete('leave_structure', 'WHERE lsID NOT IN(' . implode(',', $success) . ') AND 
                                                                           lgID = "' . (int)$groupObj->lgID . '"');
                    }
                }
                else {
                    $this->Structure->delete('leave_structure', 'WHERE lgID = "' . (int)$groupObj->lgID . '"');
                }
            }
        }
    }


    /**
     * Get File Information
     * @return mixed

    public function save( $data ) {
        $preg = '/^start_(\d)+/';

        $callback = function( $val ) use( $preg ) {
            if( preg_match( $preg, $val, $match ) ) {
                return $match;
            } else {
                return false;
            }
        };
        $structure = array_filter( $data, $callback, ARRAY_FILTER_USE_KEY );
        $sizeof = sizeof( $structure );
        $validIDs = array(0);

        if( $sizeof > 0 ) {
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];

            foreach( $structure as $key => $value ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                    $id = $match[1];

                    $info['start'] = (int)$data['start_' . $id];
                    $info['end'] = (int)$data['end_' . $id];
                    $info['days'] = (int)$data['days_' . $id];

                    if( !$data['lsID_' . $id] ) {
                        array_push( $validIDs, $this->Structure->insert( 'leave_structure', $info ) );
                    }
                    else if( $this->isFoundByID( $data['ltID'], $data['lsID_' . $id] ) ) {
                        $this->Structure->update( 'leave_structure', $info,
                                                 'WHERE ltID = "' . (int)$data['ltID'] . '" AND 
                                                               lsID = "' . (int)$data['lsID_' . $id] . '"' );

                        array_push($validIDs, $data['lsID_' . $id] );
                    }
                }
            }
            $validIDs = implode(',', $validIDs );
            $this->Structure->delete('leave_structure', 'WHERE ltID = "' . (int)$data['ltID'] . '" AND 
                                                            lsID NOT IN(' . addslashes( $validIDs ) . ')');
        }
    } */
}
?>