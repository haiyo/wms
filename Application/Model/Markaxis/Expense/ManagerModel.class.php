<?php
namespace Markaxis\Expense;
use \Markaxis\Employee\EmployeeModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ManagerModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagerModel extends \Model {


    // Properties
    protected $Manager;


    /**
     * ManagerModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Manager = new Manager( );
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
    public function getByecID( $ecID ) {
        return $this->Manager->getByecID( $ecID );
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
                $list['data'][$key]['managers'] = $this->Manager->getByecID( $value['ecID'] );
            }
        }
        return $list;
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
                }
            }
        }
        else {
            $this->Manager->delete('expense_claim_manager', 'WHERE ecID = "' . (int)$data['ecID'] . '"' );
        }
    }
}
?>