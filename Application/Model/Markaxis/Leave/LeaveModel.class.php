<?php
namespace Markaxis\Leave;
use \Aurora\User\ChildrenModel;
use \Markaxis\Employee\LeaveBalanceModel;
use \Library\IO\File;
use \Library\Util\Date;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveModel extends \Model {


    // Properties
    protected $Leave;



    /**
     * LeaveModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        File::import( DAO . 'Markaxis/Leave/Leave.class.php' );
        $this->Leave = new Leave( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getTypeListByUserID( $userID ) {
        File::import( MODEL . 'Markaxis/Employee/LeaveBalanceModel.class.php' );
        $LeaveBalanceModel = LeaveBalanceModel::getInstance( );
        return $LeaveBalanceModel->getTypeListByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getLeaveBalance( ) {
        File::import( MODEL . 'Markaxis/Employee/LeaveBalanceModel.class.php' );
        $LeaveBalanceModel = TypeModel::getInstance( );


        File::import( MODEL . 'Markaxis/Leave/TypeModel.class.php' );
        $TypeModel = TypeModel::getInstance( );
        $leaveType = $TypeModel->getFullList( );

        if( sizeof( $leaveType ) > 0 ) {
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            File::import(MODEL . 'Markaxis/Employee/EmployeeModel.class.php');
            $EmployeeModel = EmployeeModel::getInstance();
            $empInfo = $EmployeeModel->getFieldByUserID( $userInfo['userID'], 'oID, dID, cID, confirmDate, startDate, endDate' );

            foreach( $leaveType as $key => $type ) {
                $genderType = array_flip( explode( ',', $type['gender'] ) );

                if( !isset( $genderType[$userInfo['gender']] ) ) {
                    continue;
                }

                $officeType = array_flip( explode( ',', $type['office'] ) );

                if( !isset( $officeType[$empInfo['oID']] ) ) {
                    continue;
                }

                $designationType = array_flip( explode( ',', $type['designation'] ) );

                if( !isset( $designationType[$empInfo['dID']] ) ) {
                    continue;
                }

                $contractType = array_flip( explode( ',', $type['contract'] ) );

                if( !isset( $contractType[$empInfo['cID']] ) ) {
                    continue;
                }

                // If leave type is childcare leave (must have children...)
                if( $type['haveChild'] && $userInfo['children'] ) {

                    // Both of these criteria we need to retrieve children info.
                    if( $type['childAge'] && $type['childBorn'] ) {

                        File::import(MODEL . 'Aurora/user/ChildrenModel.class.php');
                        $ChildrenModel = ChildrenModel::getInstance();
                        $children = $ChildrenModel->getByUserID( $userInfo['userID'] );

                        if( $children ) {
                            // Sort children for youngest age.
                            usort($children, function( array $a, array $b ) {
                                $aTimestamp = strtotime( $a['birthday'] );
                                $bTimestamp = strtotime( $b['birthday'] );

                                if( $aTimestamp == $bTimestamp ) return 0;
                                return $aTimestamp < $bTimestamp;
                            });

                            File::import(LIB . 'Util/Date.dll.php');
                            if( !Date::getAge( $children[0]['birthday'] ) > $type['childAge'] ) {
                                // Child age overshot, no longer eligible.
                                continue;
                            }

                            if( $type['childBorn'] ) {
                                // This youngest child must be born in...
                                if( $type['childBorn'] != $children[0]['country'] ) {
                                    continue;
                                }
                            }
                        }
                    }
                }

                var_dump($userInfo);
                var_dump($type);
            }
        }
    }
}
?>