<?php
namespace Markaxis\Payroll;
use \Library\Validator\Validator;

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
     * @return mixed
     */
    public function getTotalGrossByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalGrossByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalAdditionalByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalAdditionalByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalDirectorFeeByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalDirectorFeeByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalTransportByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalTransportByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalEntertainmentByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalEntertainmentByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalOtherAllowanceByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalOtherAllowanceByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalCommissionByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalCommissionByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalPensionByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalPensionByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalGratuityByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalGratuityByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalNoticeByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalNoticeByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalExGratiaByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalExGratiaByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalOtherLumpsumByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalOtherLumpsumByUserIDRange( $userID, $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getTotalStockByUserIDRange( $userID, $startDate, $endDate ) {
        return $this->UserItem->getTotalStockByUserIDRange( $userID, $startDate, $endDate );
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

                    $data['itemRow'][] = array( 'piID' => $item['piID'],
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
     */
    public function processPayroll( $data, $post ) {
        if( isset( $post['data'] ) ) {
            $preg = '/^itemType_(\d+)+/';
            $callback = function( $val ) use( $preg ) {
                if( preg_match( $preg, $val, $match ) ) {
                    return $match;
                } else {
                    return false;
                }
            };
            $criteria = array_filter( $post['data'], $callback,ARRAY_FILTER_USE_KEY );

            foreach( $criteria as $key => $item ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) && strstr( $item,'p-' ) ) {
                    $id   = $match[1];
                    $piID = str_replace('p-', '', $item );
                    $processID = isset( $post['processID'] ) ? str_replace('p-', '', $post['processID'] ) : 0;

                    $amount = str_replace($data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                          '', $post['data']['amount_' . $id] );
                    $amount = (int)str_replace(',', '', $amount );

                    $remark = Validator::stripTrim( $post['data']['remark_' . $id] );

                    $postItem = array( 'piID' => $piID, 'amount' => $amount, 'remark' => $remark );

                    if( isset( $data['items']['ordinary'][$piID] ) || $data['items']['additional']['piID'] == $piID ||
                        $data['items']['deduction']['piID'] == $piID ) {

                        if( $data['items']['additional']['piID'] == $piID ) {
                            $postItem['additional'] = 1;
                        }

                        if( isset( $data['items']['ordinary'][$piID] ) ) {
                            $data['addGross'][] = $amount;
                        }
                        else if( $data['items']['deduction']['piID'] == $piID ) {
                            $postItem['additional'] = 0;
                            $data['deductGross'][] = $amount;
                        }

                        $data['postItems'][] = $postItem;
                    }

                    if( $piID == $processID && isset( $data['items']['directorFee'][$piID] ) ) {
                        $data['populate'] = array( 'processID' => $post['processID'],
                                                   'placeHolder' => 'AGM Approved Date (E.g: 01/12/2020)' );

                        $data['addGrossOnly'][] = $amount;
                        $data['postItems'][] = $postItem;
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

        if( isset( $data['postItems'] ) ) {
            foreach( $data['postItems'] as $item ) {
                $info = array( );
                $info['puID'] = $data['payrollUser']['puID'];
                $info['piID'] = $item['piID'];
                $info['amount'] = $item['amount'];
                $info['remark'] = $item['remark'];
                array_push($success, $this->UserItem->insert('payroll_user_item', $info ) );
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->UserItem->delete('payroll_user_item',
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
        if( isset( $data['payrollUser']['puID'] ) ) {
            $this->UserItem->delete('payroll_user_item','WHERE puID = "' . (int)$data['payrollUser']['puID'] . '"');
        }
    }
}
?>