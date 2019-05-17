<?php
namespace Markaxis\Expense;
use \Aurora\User\UserModel;
use \Library\Helper\Aurora\CurrencyHelper;
use \Library\Validator\Validator;

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
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Claim = new Claim( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $userInfo = UserModel::getInstance( )->getInfo( );
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
                case 3:
                    $order = 'ec.amount';
                    break;
            }
        }
        $results = $this->Claim->getResults( $userInfo['userID'], $post['search']['value'], $order . $dir );
        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $this->info['ecID'] = (int)$data['ecID'];
        $this->info['descript'] = Validator::stripTrim( $data['claimDescript'] );

        $ExpenseModel = ExpenseModel::getInstance( );
        if( isset( $ExpenseModel->getList( )[$data['expense']] ) ) {
            $this->info['etID'] = (int)$data['expense'];
        }
        else {
            $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_CLAIM_TYPE') );
            return false;
        }

        if( isset( CurrencyHelper::getL10nList( )[$data['currency']] ) ) {
            $saveInfo['currency'] = $data['currency'];
        }
        else {
            $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_CURRENCY') );
            return false;
        }

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        $this->info['userID'] = $userInfo['userID'];

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
            $this->Claim->update( 'expense_claim', $this->info,
                                  'WHERE ecID = "' . (int)$this->info['ecID'] . '"' );
        }
        return $this->info['ecID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $oID ) {
        $A_OfficeModel = A_OfficeModel::getInstance( );

        if( $A_OfficeModel->isFound( $oID ) ) {
            $info = array( );
            $info['deleted'] = 1;
            $this->Office->update( 'office', $info, 'WHERE oID = "' . (int)$oID . '"' );
        }
    }
}
?>