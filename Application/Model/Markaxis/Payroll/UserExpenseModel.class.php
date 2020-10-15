<?php
namespace Markaxis\Payroll;
use \Markaxis\Expense\ExpenseModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserExpenseModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserExpenseModel extends \Model {


    // Properties
    protected $UserExpense;



    /**
     * UserExpenseModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->UserExpense = new UserExpense( );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByPuID( $puID ) {
        return $this->UserExpense->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getExistingItems( $data ) {
        if( isset( $data['payrollUser']['puID'] ) ) {
            $listItems = $this->getByPuID( $data['payrollUser']['puID'] );

            if( sizeof( $listItems ) > 0 ) {
                foreach( $listItems as $item ) {
                    $data['addGross'][] = $item['amount'];

                    $data['itemRow'][] = array( 'eiID' => $item['eiID'],
                                                'title' => $item['title'],
                                                'amount' => $item['amount'],
                                                'remark' => $item['remark'] );
                }
            }
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int

    public function processPayroll( $data, $post ) {
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
            $success = array( );

            $ExpenseModel = ExpenseModel::getInstance( );

            foreach( $criteria as $key => $item ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) && strstr( $item,'e-' ) ) {
                    $id   = $match[1];
                    $eiID = str_replace('e-', '', $item );

                    if( $ExpenseModel->isFoundByeiID( $eiID ) ) {
                        $info = array( );
                        $info['puID'] = $data['puID'];
                        $info['eiID'] = $eiID;
                        $info['amount'] = str_replace($data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                      '', $post['data']['amount_' . $id] );
                        $info['amount'] = (int)str_replace(',', '', $info['amount'] );

                        $info['remark'] = Validator::stripTrim( $post['data']['remark_' . $id] );

                        array_push($success, $this->UserExpense->insert('payroll_user_expense', $info ) );
                    }
                }
            }
            if( sizeof( $success ) > 0 ) {
                $this->UserExpense->delete('payroll_user_expense',
                    'WHERE puiID NOT IN(' . implode(',', $success ) . ') AND 
                                                     puID = "' . (int)$data['puID'] . '"');
            }
            else {
                $this->deletePayroll( $data );
            }
        }
    } */


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $data, $post ) {
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
            $ExpenseModel = ExpenseModel::getInstance( );

            foreach( $criteria as $key => $item ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) && strstr( $item,'e-' ) ) {
                    $id   = $match[1];
                    $eiID = str_replace('e-', '', $item );

                    if( $ExpenseModel->isFoundByeiID( $eiID ) ) {

                        $amount = str_replace($data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                             '', $post['data']['amount_' . $id] );
                        $amount = (int)str_replace(',', '', $amount );

                        $remark = Validator::stripTrim( $post['data']['remark_' . $id] );

                        $data['claims'][] = array( 'eiID' => $eiID, 'amount' => $amount, 'remark' => $remark );
                        $data['addNet'][] = $amount;
                    }
                }
            }
            return $data;
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        $success = array( );

        if( isset( $data['claims'] ) ) {
            foreach( $data['claims'] as $claim ) {
                $info = array( );
                $info['puID'] = $data['payrollUser']['puID'];
                $info['eiID'] = $claim['eiID'];
                $info['amount'] = $claim['amount'];
                $info['remark'] = $claim['remark'];
                array_push($success, $this->UserExpense->insert('payroll_user_expense', $info ) );
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->UserExpense->delete('payroll_user_expense',
                                       'WHERE puiID NOT IN(' . implode(',', $success ) . ') AND 
                                                     puID = "' . (int)$data['payrollUser']['puID'] . '"');
        }
        else {
            $this->deletePayroll( $data );
        }
        return $data;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['puID'] ) ) {
            $this->UserExpense->delete('payroll_user_expense','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>