<?php
namespace Markaxis\Expense;
use \Markaxis\Employee\EmployeeModel;
use \Aurora\User\UserModel;
use \Aurora\Component\UploadModel;
use \Library\Util\Uploader, \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ClaimModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ClaimModel extends \Model {


    // Properties
    protected $Claim;


    /**
     * ClaimModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->Claim = new Claim( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ecID ) {
        return $this->Claim->isFound( $ecID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function isFoundByEcIDUserID( $ecID, $userID, $status ) {
        return $this->Claim->isFoundByEcIDUserID( $ecID, $userID, $status );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByEcID( $ecID ) {
        return $this->Claim->getByEcID( $ecID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByUserIDStatus( $userID, $startDate, $endDate, $status ) {
        return $this->Claim->getByUserIDStatus( $userID, $startDate, $endDate, $status );
    }


    /**
     * Return total count of records
     * @return mixed

    public function getApprovedByUserID( $userID, $startDate, $endDate, $status ) {
        return $this->Claim->getByUserIDStatus( $userID, $startDate, $endDate, $status );
    } */


    /**
     * Return total count of records
     * @return mixed
     */
    public function getPendingAction( $userID ) {
        return $this->Claim->getPendingAction( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getRequest( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        return $this->Claim->getRequest( $userInfo['userID'] );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Claim->setLimit( $post['start'], $post['length'] );

        $order = 'ei.title';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'ei.title';
                    break;
                case 2:
                    $order = 'ec.descript';
                    break;
                default:
                    $order = 'ec.amount';
                    break;
            }
        }
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        $results = $this->Claim->getResults( $userInfo['userID'], $post['search']['value'], $order . $dir );
        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getChart( $date ) {
        return array( 'claims' => $this->Claim->getChart( $date ) );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function setStatus( $ecID, $status ) {
        $this->Claim->update('expense_claim', array( 'status' => $status ),
                             'WHERE ecID = "' . (int)$ecID . '"' );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByRange( $data, $status ) {
        $claims = array( );

        if( isset( $data['payCal']['rangeStart'] ) && isset( $data['payCal']['rangeEnd'] ) ) {
            $rangeStart = $data['payCal']['rangeStart']->format('Y-m-d');
            $rangeEnd   = $data['payCal']['rangeEnd']->format('Y-m-d 23:59:59');

            $claimInfo = $this->getByUserIDStatus( $data['empInfo']['userID'], $rangeStart, $rangeEnd, $status );

            if( sizeof( $claimInfo ) > 0 ) {
                foreach( $claimInfo as $value ) {
                    $claims[] = array( 'ecID' => $value['ecID'],
                                       'eiID' => $value['eiID'],
                                       'remark' => $value['descript'],
                                       'amount' => $value['amount'] );
                }
            }
        }
        return $claims;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data, $post ) {
        if( isset( $data['empInfo'] ) && isset( $post['data']['claim'] ) && is_array( $post['data']['claim'] ) ) {
            foreach( $post['data']['claim'] as $ecID ) {
                if( $this->isFoundByEcIDUserID( $ecID, $data['empInfo']['userID'],1 ) ) {
                    $this->Claim->update('expense_claim', array( 'status' => 2 ),
                                         'WHERE ecID = "' . (int)$ecID . '"' );
                }
            }
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['empInfo']['userID'] ) && isset( $data['payCal']['rangeStart'] ) && isset( $data['payCal']['rangeEnd'] ) ) {
            $rangeStart = $data['payCal']['rangeStart']->format('Y-m-d');
            $rangeEnd   = $data['payCal']['rangeEnd']->format('Y-m-d H:i:s');

            $this->Claim->update('expense_claim', array( 'status' => 1 ),
                                 'WHERE userID = "' . (int)$data['empInfo']['userID'] . '" AND
                                               created BETWEEN "' . addslashes( $rangeStart ) . '" AND "' . addslashes( $rangeEnd ) . '" AND
                                               status = "2"' );
        }
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $this->info['ecID'] = (int)$data['ecID'];
        $this->info['descript'] = Validator::stripTrim( $data['claimDescript'] );
        $this->info['amount'] = Validator::stripTrim( $data['claimAmount'] );

        $ExpenseModel = ExpenseModel::getInstance( );

        if( $exInfo = $ExpenseModel->getByeiID( $data['expense'] ) ) {
            $this->info['eiID'] = (int)$data['expense'];
        }
        else {
            $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_CLAIM_TYPE') );
            return false;
        }

        if( $exInfo['max_amount'] && $this->info['amount'] > $exInfo['max_amount'] ) {
            $EmployeeModel = EmployeeModel::getInstance( );
            $empInfo = $EmployeeModel->getInfo( );

            $this->setErrMsg( $this->L10n->strReplace( 'maxAmount', $empInfo['currency'] . $exInfo['max_amount'],
                                                       'LANG_AMOUNT_OVER_MAX' ) );
            return false;
        }

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        $this->info['userID'] = $userInfo['userID'];
        $this->info['created'] = date( 'Y-m-d H:i:s' );
        return true;
    }


    /**
     * Save Pay Item information
     * @return int
     */
    public function save( ) {
        if( !$this->info['ecID'] ) {
            unset( $this->info['ecID'] );
            $this->info['ecID'] = $this->Claim->insert( 'expense_claim', $this->info );
        }
        else {
            $this->Claim->update('expense_claim', $this->info,
                                 'WHERE ecID = "' . (int)$this->info['ecID'] . '"' );
        }
        return $this->info['ecID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function cancel( $ecID ) {
        if( $this->isFound( $ecID ) ) {
            $this->Claim->update( 'expense_claim', array( 'cancelled' => 1 ),
                                 'WHERE ecID = "' . (int)$ecID . '"' );
        }
    }


    /**
     * Upload file
     * @return bool
     */
    public function uploadSuccess( $ecID, $file ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( $this->isFoundByEcIDUserID( $ecID, $userInfo['userID'],0 ) ) {
            $Uploader = new Uploader([
                'uploadDir' => USER_CLAIM_DIR
            ]);

            if( $Uploader->validate( $file['file_data'] ) && $Uploader->upload( ) ) {
                $fileInfo = $Uploader->getFileInfo( );

                $UploadModel = new UploadModel( );
                $fileInfo['uID'] = $UploadModel->saveUpload( $fileInfo );

                if( $fileInfo['error'] ) {
                    $this->setErrMsg( $fileInfo['error'] );
                    return false;
                }

                if( $fileInfo['success'] == 2 && $fileInfo['isImage'] ) {
                    $UploadModel->processResize( $fileInfo );
                }
                $this->Claim->update('expense_claim', array( 'uID' => $fileInfo['uID'] ),
                                    'WHERE ecID = "' . (int)$ecID . '"' );

                return true;
            }
            $this->setErrMsg( $Uploader->getFileInfo( )['error'] );
            return false;
        }
    }
}
?>