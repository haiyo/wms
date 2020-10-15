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
    private $itemList;



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
        if( $this->itemList ) {
            return $this->itemList;
        }
        return $this->itemList = $this->Item->getList( );
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
     * @return mixed
     */
    public function getBypiID( $piID ) {
        return $this->Item->getBypiID( $piID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByPuID( $puID ) {
        return $this->Item->getByPuID( $puID );
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
    public function getAdditional( ) {
        return $this->Item->getAdditional( );
    }


    /**
     * Get Table Results
     * @return mixed
     */
    public function getResults( $data ) {
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
        $results = $this->Item->getResults( $data['search']['value'], $order . $dir );
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
    public function getAllItems( $data, $viewSaved ) {
        $data['items']['basic'] = $this->getBasic( );
        $data['items']['ordinary'] = $this->getOrdinary( );
        $data['items']['deduction'] = $this->getDeduction( );
        $data['items']['additional'] = $this->getAdditional( );

        $data['items']['basic']['amount'] = $data['items']['totalOrdinary'] = 0;

        if( $data['items']['basic'] && isset( $data['empInfo']['salary'] ) && is_numeric( $data['empInfo']['salary'] ) &&
            $data['empInfo']['salary'] > 0 ) {

            $data['items']['totalOrdinary'] = $data['empInfo']['salary'];

            $row = array( 'piID' => $data['items']['basic']['piID'],
                          'amount' => $data['empInfo']['salary'],
                          'remark' => '' );

            $data['postItems'][] = $row;

            if( !$viewSaved ) {
                $data['itemRow'][] = $row;
            }
        }
        return $data;
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $this->info['piID'] = (int)$data['piID'];
        $this->info['title'] = Validator::stripTrim( $data['payItemTitle'] );
        $this->info['formula'] = trim( $data['formula'] );
        $this->info['ordinary'] = 1;
        $this->info['taxable'] = isset( $data['taxable'] ) ? 1 : 0;

        $Validator = new Validator( );
        $Validator->addModule( 'payItemTitle', new IsEmpty( $this->info['title'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
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
            $this->info['piID'] = $this->Item->insert( 'payroll_item', $this->info );
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