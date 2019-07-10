<?php
namespace Markaxis\Payroll;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ItemModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemModel extends \Model {


    // Properties
    protected $Item;



    /**
     * ItemModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Item = new Item( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $piID ) {
        return $this->Item->isFound( $piID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Item->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getProcessList( ) {
        return $this->Item->getProcessList( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBypiID( $piID ) {
        return $this->Item->getBypiID( $piID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getBasic( ) {
        return $this->Item->getBasic( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getOrdinary( ) {
        return $this->Item->getOrdinary( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getDeduction( ) {
        return $this->Item->getDeduction( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getDeductionAW( ) {
        return $this->Item->getDeductionAW( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getAdditional( ) {
        return $this->Item->getAdditional( );
    }


    /**
     * Get Table Results
     * @return mixed
     */
    public function getItemResults( $data ) {
        $this->Item->setLimit( $data['start'], $data['length'] );

        $order = 'pi.title';
        $dir   = isset( $data['order'][0]['dir'] ) && $data['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $data['order'][0]['column'] ) ) {
            switch( $data['order'][0]['column'] ) {
                case 1:
                    $order = 'pi.title';
                    break;
                case 2:
                    $order = 'pi.ordinary';
                    break;
                case 3:
                    $order = 'pi.deduction';
                    break;
                case 4:
                    $order = 'pi.additional';
                    break;
                default:
                    $order = 'pi.claim';
                    break;
            }
        }
        $results = $this->Item->getItemResults( $data['search']['value'], $order . $dir );
        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$data['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getAllItems( $data ) {
        $items = array( );
        $items['basic'] = $this->getBasic( );
        $items['ordinary'] = $this->getOrdinary( );
        $items['deduction'] = $this->getDeduction( );
        $items['deductionAW'] = $this->getDeductionAW( );
        $items['additional'] = $this->getAdditional( );

        if( isset( $data['empInfo']['salary'] ) && is_numeric( $data['empInfo']['salary'] ) &&
            $data['empInfo']['salary'] > 0 && isset( $items['basic']['piID'] ) ) {
            if( isset( $items['ordinary'][$items['basic']['piID']] ) ) {
                $items['ordinary'][$items['basic']['piID']]['amount'] = $data['empInfo']['salary'];
            }
        }
        return $items;
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
            $criteria = array_filter( $post['data'], $callback, ARRAY_FILTER_USE_KEY );
            $post['postItems'] = array( );

            foreach( $criteria as $key => $item ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) && strstr( $item,'p-' ) ) {
                    $id = $match[1];

                    $piID = str_replace( 'p-', '', $item );

                    if( isset( $post['data']['amount_' . $id] ) ) {
                        $amount = str_replace( $data['empInfo']['currency'], '', $post['data']['amount_' . $id] );
                        $amount = (int)str_replace( ',', '', $amount );

                        if( $amount > 0 ) {
                            $post['postItems'][] = array( 'piID' => $piID,
                                                          'amount' => $amount );
                        }
                    }
                }
            }
            return $post;
        }
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $this->info['piID'] = (int)$data['piID'];
        $this->info['title'] = Validator::stripTrim( $data['payItemTitle'] );

        $Validator = new Validator( );
        $Validator->addModule( 'payItemTitle', new IsEmpty( $this->info['title'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }

        if( $data['payItemType'] == 'ordinary' ) {
            $this->info['ordinary'] = 1;
        }
        else if( $data['payItemType'] == 'deduction' ) {
            $this->info['deduction'] = 1;
        }
        else if( $data['payItemType'] == 'additional' ) {
            $this->info['additional'] = 1;
        }
        else if( $data['payItemType'] == 'claim' ) {
            $this->info['claim'] = 1;
        }
        return true;
    }


    /**
     * Save Pay Item information
     * @return int
     */
    public function save( ) {
        if( !$this->info['piID'] ) {
            unset( $this->info['piID'] );
            $this->info['piID'] = $piID = $this->Item->insert( 'payroll_item', $this->info );
        }
        else {
            $this->Item->update( 'payroll_item', $this->info, 'WHERE piID = "' . (int)$this->info['piID'] . '"' );
        }
        return $this->info['piID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $data ) {
        $deleted = 0;

        if( is_array( $data ) ) {
            foreach( $data as $piID ) {
                $info = array( );
                $info['deleted'] = 1;
                $this->Item->update( 'payroll_item', $info, 'WHERE piID = "' . (int)$piID . '"' );
                $deleted++;
            }
        }
        return $deleted;
    }
}
?>