<?php
namespace Markaxis\Expense;
use \Markaxis\Employee\EmployeeModel;
use \Aurora\User\UserModel, \Aurora\Notification\NotificationModel;
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
        $this->L10n = $i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->Manager = new Manager( );
        $this->addObservers( new NotificationModel( ) );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ecID, $userID ) {
        return $this->Manager->isFound( $ecID, $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByEcID( $ecID ) {
        return $this->Manager->getByEcID( $ecID );
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
    public function getResults( $list ) {
        if( isset( $list['data'] ) ) {
            foreach( $list['data'] as $key => $value ) {
                $list['data'][$key]['managers'] = $this->Manager->getByEcID( $value['ecID'] );
            }
        }
        return $list;
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getCountPending( $ecID ) {
        return $this->Manager->getCountPending( $ecID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getRequest( $list ) {
        if( is_array( $list ) ) {
            foreach( $list as $key => $value ) {
                $list[$key]['managers'] = $this->Manager->getByEcID( $value['ecID'] );
            }
        }
        return $list;
    }


    /**
     * Render main navigation
     * @return bool
     */
    public function setClaimAction( $data ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( isset( $data['ecID'] ) && $this->isFound( $data['ecID'], $userInfo['userID'] ) ) {
            $info = array( );
            $info['approved'] = $data['approved'];
            $this->Manager->update( 'expense_claim_manager', $info,
                                    'WHERE managerID="' . (int)$userInfo['userID'] . '" AND
                                                  ecID = "' . (int)$data['ecID'] . '"' );

            // Immediate disapprove if one manager disapproved
            $ClaimModel = ClaimModel::getInstance( );

            if( $data['approved'] == '-1' ) {
                $ClaimModel->setStatus( $data['ecID'], '-1' );
            }
            // Check if needed more approval
            else if( !$this->getCountPending( $data['ecID'] ) ) {
                $ClaimModel->setStatus( $data['ecID'], 1 );
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
        // Make sure userID has "passed" from UserModel before proceed
        if( isset( $data['managers'] ) && isset( $data['ecID'] ) && $data['ecID'] ) {
            $success = array( );
            $managers = explode( ';', $data['managers'] );

            if( sizeof( $managers ) > 0 ) {
                $EmployeeModel = new EmployeeModel( );

                foreach( $managers as $managerID ) {
                    $value = (int)$managerID;

                    if( $value && $EmployeeModel->isFoundByUserID( $managerID ) &&
                        !$this->isFound( $data['ecID'], $managerID ) ) {
                        $info = array( );
                        $info['ecID'] = (int)$data['ecID'];
                        $info['managerID'] = $managerID;
                        $this->Manager->insert( 'expense_claim_manager', $info );
                    }
                    array_push( $success, $managerID );
                }
                if( sizeof( $success ) > 0 ) {
                    $this->Manager->delete('expense_claim_manager', 'WHERE ecID = "' . (int)$data['ecID'] . '" AND 
                                              managerID NOT IN(' . addslashes( implode( ',', $success ) ) . ')' );

                    $this->info['userID'] = $data['userID'];
                    $this->info['toUserID'] = $success;
                    $this->info['url'] = $data['userID'];
                    $this->info['message'] = $this->L10n->getContents('LANG_CLAIM_PENDING_APPROVAL');
                    $this->info['created'] = $data['created'];
                    $this->notifyObservers('notify' );
                }
            }
        }
        else {
            $this->Manager->delete('expense_claim_manager', 'WHERE ecID = "' . (int)$data['ecID'] . '"' );
        }
    }
}
?>