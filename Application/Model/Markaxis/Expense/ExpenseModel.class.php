<?php
namespace Markaxis\Expense;
use \Markaxis\Employee\EmployeeModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ExpenseModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseModel extends \Model {


    // Properties
    protected $Expense;
    private $expenseList;


    /**
     * ExpenseModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->Expense = new Expense( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByeiID( $eiID ) {
        return $this->Expense->isFoundByeiID( $eiID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByeiID( $eiID ) {
        return $this->Expense->getByeiID( $eiID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByUserID( $userID ) {
        return $this->Expense->getByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        if( $this->expenseList ) {
            return $this->expenseList;
        }
        return $this->expenseList = $this->Expense->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getMaxAmount( $eiID ) {
        if( $exInfo = $this->getByeiID( $eiID ) ) {
            $EmployeeModel = EmployeeModel::getInstance( );
            $empInfo = $EmployeeModel->getInfo( );

            if( $exInfo['max_amount'] ) {
                return $this->L10n->strReplace( 'maxAmount', $empInfo['currency'] . $exInfo['max_amount'],
                                                'LANG_MAX_AMOUNT' );
            }
        }
        else {
            $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_CLAIM_TYPE') );
            return false;
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Expense->setLimit( $post['start'], $post['length'] );

        $order = 'ei.title';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'ei.title';
                    break;
                case 2:
                    $order = 'ei.amount';
                    break;
            }
        }
        $results = $this->Expense->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function reprocessPayroll( $data, $post ) {
        if( isset( $post['data'] ) ) {
            $preg = '/^itemType_(\d)+/';
            $callback = function( $val ) use( $preg ) {
                if( preg_match( $preg, $val, $match ) ) {
                    return $match;
                } else {
                    return false;
                }
            };
            $criteria = array_filter( $post['data'], $callback,ARRAY_FILTER_USE_KEY );
            $post['postItems'] = array( );

            foreach( $criteria as $key => $item ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) && strstr( $item,'e-' ) ) {
                    $id   = $match[1];
                    $eiID = str_replace('e-', '', $item );

                    if( $this->isFound( $eiID ) && isset( $post['data']['amount_' . $id] ) ) {
                        $amount = str_replace( $data['empInfo']['currency'], '', $post['data']['amount_' . $id] );
                        $amount = (int)str_replace(',', '', $amount );
                        $remark = Validator::stripTrim( $post['data']['remark_' . $id] );

                        if( $amount > 0 ) {
                            $post['postItems'][] = array( 'eiID' => $eiID, 'amount' => $amount, 'remark' => $remark );
                        }
                    }
                }
            }
            return $post;
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function saveExpenseType( $data ) {
        $eiID = (int)$data['eiID'];
        $this->info['title'] = Validator::stripTrim( $data['expenseTitle'] );
        $this->info['max_amount'] = Validator::stripTrim( $data['expenseAmount'] );

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );
        $this->info['max_amount'] = number_format( str_replace( $empInfo['currency'],'',$this->info['max_amount'] ) );

        if( $this->isFoundByeiID( $eiID ) ) {
            $this->Expense->update( 'expense_item', $this->info, 'WHERE eiID = "' . (int)$eiID . '"' );
        }
        else {
            $this->info['eiID'] = $this->Expense->insert('expense_item', $this->info );
        }
        return $this->info['eiID'];
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deleteExpense( $data ) {
        if( isset( $data['eiID'] ) ) {
            return $this->Expense->update('expense_item', array( 'deleted' => 1 ), 'WHERE eiID = "' . (int)$data['eiID'] . '"');
        }
    }
}
?>