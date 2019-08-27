<?php
namespace Markaxis\Expense;
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



    /**
     * ExpenseModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Expense = new Expense( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $eiID ) {
        return $this->Expense->isFound( $eiID );
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
        return $this->Expense->getList( );
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
     * Return total count of records
     * @return int

    public function savePayroll( $data, $post ) {
        $post = $this->reprocessPayroll( $data, $post );

        if( sizeof( $post['postItems'] ) ) {
            foreach( $post['postItems'] as $item ) {
                $info = array( );
                $info['userID'] = $data['empInfo']['userID'];
                $info['eiID'] = $item['eiID'];
                $info['amount'] = $item['amount'];
                $info['remark'] = $item['remark'];
                $this->Expense->insert( 'payroll_user_expense', $info );
            }
        }
    } */
}
?>