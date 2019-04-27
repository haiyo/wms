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
    public function getProcessItem( $userID, $loadPrevMonth ) {
        if( $loadPrevMonth ) {
            //
        }
        else {
            return $this->Item->getBasic( );
        }
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
                    $order = 'pi.basic';
                    break;
                case 3:
                    $order = 'pi.deduction';
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
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $Validator = new Validator( );

        $this->info['piID'] = (int)$data['piID'];
        $this->info['title'] = Validator::stripTrim( $data['payItemTitle'] );

        $Validator->addModule( 'payItemTitle', new IsEmpty( $this->info['title'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }

        if( $data['payItemType'] == 'basic' ) {
            $this->info['basic'] = 1;
        }
        else if( $data['payItemType'] == 'deduction' ) {
            $this->info['deduction'] = 1;
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