<?php
namespace Markaxis\Leave;
use \Aurora\Component\CountryModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: GroupModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GroupModel extends \Model {


    // Properties
    protected $Group;



    /**
     * GroupModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Group = new Group( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $lgID ) {
        return $this->Group->isFound( $lgID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByID( $lgID ) {
        $groupInfo = $this->Group->getByID( $lgID );

        if( $groupInfo ) {
            $groupInfo['entitledLeaves'] = (float)$groupInfo['entitledLeaves'];
        }
        return $groupInfo;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByltID( $ltID ) {
        return $this->Group->getByltID( $ltID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByLeaveTypes( $leaveTypes ) {
        foreach( $leaveTypes as $key => $type ) {
            $leaveTypes[$key]['group'] = $this->Group->getByltID( $type['ltID'] );
        }
        return $leaveTypes;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['ltID'] ) && isset( $data['leaveGroups'] ) && $data['leaveGroups'] ) {
            $data['leaveGroups'] = json_decode( $data['leaveGroups'] );

            foreach( $data['leaveGroups'] as $key => $groupObj ) {
                if( isset( $groupObj->lgID ) ) {
                    $info = array( );
                    $info['ltID'] = $data['ltID'];
                    $info['title'] = Validator::stripTrim( $groupObj->groupTitle );
                    $info['proRated'] = $groupObj->proRated == 1 ? 1 : 0;
                    $info['childCare'] = $groupObj->childCare == 1 ? 1 : 0;
                    $info['childBorn'] = (int)$groupObj->childBorn;
                    $info['childNotBorn'] = (int)$groupObj->childNotBorn;
                    $info['childAge'] = (int)$groupObj->childAge;
                    $info['entitledLeaves'] = (float)$groupObj->entitledLeaves;

                    if( $info['childCare'] ) {
                        $CountryModel = CountryModel::getInstance( );
                        $countryInfo = $CountryModel->getList( );

                        if( $info['childBorn'] && isset( $countryInfo[$info['childBorn']] ) ) {
                            $this->info['childBorn'] = (int)$info['childBorn'];
                        }
                        if( $info['childNotBorn'] && isset( $countryInfo[$info['childNotBorn']] ) ) {
                            $this->info['childNotBorn'] = (int)$info['childNotBorn'];
                        }
                    }

                    if( $groupObj->lgID > 0 && $grpInfo = $this->getByID( $groupObj->lgID ) ) {
                        $this->Group->update('leave_group', $info,
                                            'WHERE lgID = "' . (int)$grpInfo['lgID'] . '"' );
                    }
                    else {
                        $lgID = $this->Group->insert('leave_group', $info );
                        $data['leaveGroups'][$key]->lgID = $lgID;
                    }
                }
                else {
                    // Unset only invalid group!
                    unset( $data['leaveGroups'][$key] );
                }
            }
        }
        return $data;
    }
}
?>