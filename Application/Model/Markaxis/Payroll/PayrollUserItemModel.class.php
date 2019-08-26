<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollUserItemModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollUserItemModel extends \Model {


    // Properties
    protected $PayrollUserItem;



    /**
     * PayrollUserItemModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->PayrollUserItem = new PayrollUserItem( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getUserPayroll( $pID, $userID ) {
        return $this->PayrollUserItem->getUserPayroll( $pID, $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data, $post ) {
        $success = array( );

        if( isset( $data['items'] ) && sizeof( $data['items'] ) ) {
            foreach( $data['items'] as $item ) {
                $info = array( );
                $info['puID'] = $data['puID'];
                $info['piID'] = $item['piID'];
                $info['amount'] = $item['amount'];
                $info['remark'] = $item['remark'];
                array_push($success, $this->PayrollUserItem->insert( 'payroll_user_item', $info ) );
            }
        }
        if( isset( $post['data'] ) && sizeof( $post['data'] ) ) {
            $postData = array_reverse( $post['data'] );
            $preg = '/^itemType_(\d)+/';
            $callback = function( $val ) use( $preg ) {
                if( preg_match( $preg, $val, $match ) ) {
                    return $match;
                } else {
                    return false;
                }
            };
            $criteria = array_filter( $postData, $callback,ARRAY_FILTER_USE_KEY );

            if( sizeof( $criteria ) > 0 ) {
                foreach( $criteria as $key => $item ) {
                    preg_match( $preg, $key, $match );

                    if( isset( $match[1] ) && is_numeric( $match[1] ) && strstr( $item, 'p-' ) ) {
                        $id   = $match[1];
                        $piID = str_replace('p-','', $item );
                        $amount = str_replace( $data['empInfo']['currency'], '', $postData['amount_' . $id] );
                        $amount = (int)str_replace(',', '', $amount );

                        $info = array( );
                        $info['puID'] = $data['puID'];
                        $info['piID'] = $piID;
                        $info['amount'] = $amount;
                        $info['remark'] = $postData['remark_' . $id];
                        array_push($success, $this->PayrollUserItem->insert('payroll_user_item', $info ) );

                        if( $data['deduction']['piID'] == $piID && isset( $data['summary']['deduction'] ) ) {
                            $data['summary']['deduction'] += $amount;
                        }
                    }
                }
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->PayrollUserItem->delete('payroll_user_item',
                                           'WHERE puiID NOT IN(' . implode(',', $success ) . ') AND 
                                                        puID = "' . (int)$data['puID'] . '"');
        }
        else {
            $this->PayrollUserItem->delete('payroll_user_item','WHERE puID = "' . (int)$data['puID'] . '"');
        }
        return $data;
    }
}
?>