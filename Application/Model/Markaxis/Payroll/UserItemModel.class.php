<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserItemModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserItemModel extends \Model {


    // Properties
    protected $UserItem;



    /**
     * UserItemModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->UserItem = new UserItem( );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByPuID( $puID ) {
        return $this->UserItem->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getExistingItem( $data ) {
        if( isset( $data['payrollUser'] ) ) {
            $listItems = $this->getByPuID( $data['payrollUser']['puID'] );

            if( sizeof( $listItems ) > 0 ) {
                foreach( $listItems as $item ) {
                    $data['addGross'][] = $item['amount'];

                    $data['itemRow'][] = array( 'piID' => $item['piID'],
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
     */
    public function savePayroll( $data, $post ) {
        $success = array( );

        if( isset( $post['postItems'] ) ) {
            foreach( $post['postItems'] as $item ) {
                $info = array( );
                $info['puID'] = $data['puID'];
                $info['piID'] = $item['piID'];
                $info['amount'] = $item['amount'];
                $info['remark'] = $item['remark'];
                array_push($success, $this->UserItem->insert('payroll_user_item', $info ) );
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->UserItem->delete('payroll_user_item',
                                    'WHERE puiID NOT IN(' . implode(',', $success ) . ') AND 
                                                  puID = "' . (int)$data['puID'] . '"');
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
            $this->UserItem->delete('payroll_user_item','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>