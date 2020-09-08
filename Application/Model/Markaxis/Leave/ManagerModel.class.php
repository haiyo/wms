<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\EmployeeModel;
use \Aurora\Notification\NotificationModel, \Aurora\User\UserModel;
use \Library\Interfaces\IObservable;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ManagerModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagerModel extends \Model implements IObservable {


    // Properties
    protected $Manager;


    /**
     * ManagerModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $i18n->loadLanguage('Markaxis/Leave/ManagerRes');

        $this->Manager = new Manager( );
        $this->addObservers( new NotificationModel( ) );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $laID, $userID ) {
        return $this->Manager->isFound( $laID, $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByUserID( $userID ) {
        return $this->Manager->getByUserID( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getSuggestToken( $userID ) {
        return $this->Manager->getSuggestToken( $userID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getHistory( $list ) {
        if( isset( $list['data'] ) ) {
            foreach( $list['data'] as $key => $value ) {
                $list['data'][$key]['managers'] = $this->Manager->getBylaID( $value['laID'] );
            }
        }
        return $list;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getRequest( $list ) {
        if( is_array( $list ) ) {
            foreach( $list as $key => $value ) {
                $list[$key]['managers'] = $this->Manager->getBylaID( $value['laID'] );
            }
        }
        return $list;
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getCountPending( $laID ) {
        return $this->Manager->getCountPending( $laID );
    }


    /**
     * Render main navigation
     * @return bool
     */
    public function setLeaveAction( $data ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( isset( $data['laID'] ) && $this->isFound( $data['laID'], $userInfo['userID'] ) ) {
            $info = array( );
            $info['approved'] = $data['approved'];
            $this->Manager->update( 'leave_apply_manager', $info,
                                    'WHERE managerID="' . (int)$userInfo['userID'] . '" AND 
                                                  laID = "' . (int)$data['laID'] . '"' );

            // Immediate disapprove if one manager disapproved
            $LeaveApplyModel = LeaveApplyModel::getInstance( );

            if( $data['approved'] == '-1' ) {
                $LeaveApplyModel->setStatus( $data['laID'], '-1' );
            }
            // Check if needed more approval
            else if( !$this->getCountPending( $data['laID'] ) ) {
                $LeaveApplyModel->setStatus( $data['laID'], 1 );
            }
            return true;
        }
        return false;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
        $hasSup = false;
        $managerIDs = array( );

        // Make sure userID has "passed" from UserModel before proceed
        if( isset( $data['managers'] ) && isset( $data['laID'] ) && $data['laID'] ) {
            $managers = explode(';', $data['managers'] );

            if( sizeof( $managers ) > 0 ) {
                $EmployeeModel = new EmployeeModel( );

                foreach( $managers as $value ) {
                    $value = (int)$value;

                    if( $value && $EmployeeModel->isFoundByUserID( $value ) ) {
                        $info = array( );
                        $info['laID'] = (int)$data['laID'];
                        $info['managerID'] = $value;
                        $this->Manager->insert('leave_apply_manager', $info );
                        array_push($managerIDs, $info['managerID'] );
                        $hasSup = true;
                    }
                }
                if( $hasSup ) {
                    $this->info['userID'] = $data['userID'];
                    $this->info['toUserID'] = $managerIDs;
                    $this->info['url'] = $data['userID'];
                    $this->info['message'] = $this->L10n->getContents('LANG_LEAVE_PENDING_APPROVAL');
                    $this->info['created'] = $data['created'];
                    $this->notifyObservers('notify' );
                }
            }
        }
        return $hasSup;
    }
}
?>