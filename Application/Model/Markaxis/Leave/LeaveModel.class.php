<?php
namespace Markaxis\Leave;
use \Aurora\User\ChildrenModel;
use \Markaxis\Employee\LeaveBalanceModel;
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

        $this->Leave = new Leave( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getTypeListByUserID( $userID ) {
        $LeaveBalanceModel = LeaveBalanceModel::getInstance( );
        return $LeaveBalanceModel->getTypeListByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getLeaveBalance( ) {
        $LeaveBalanceModel = TypeModel::getInstance( );

        $TypeModel = TypeModel::getInstance( );
        $leaveType = $TypeModel->getFullList( );

        if( sizeof( $leaveType ) > 0 ) {
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo  = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            $EmployeeModel = EmployeeModel::getInstance();
            $empInfo = $EmployeeModel->getFieldByUserID( $userInfo['userID'], 'oID, dID, cID, confirmDate, startDate, endDate' );

            foreach( $leaveType as $key => $type ) {
                // If leave type is childcare leave (must have children...)
                if( $type['haveChild'] && $userInfo['children'] ) {

                    // Both of these criteria we need to retrieve children info.
                    if( $type['childAge'] && $type['childBorn'] ) {
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