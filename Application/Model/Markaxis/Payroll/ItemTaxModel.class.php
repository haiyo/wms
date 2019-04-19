<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\TaxModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ItemTaxModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemTaxModel extends \Model {


    // Properties
    protected $ItemTax;



    /**
     * ItemModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->ItemTax = new ItemTax( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getItemResults( $list ) {
        if( isset( $list['data'] ) ) {
            foreach( $list['data'] as $key => $value ) {
                $list['data'][$key]['taxGroups'] = $this->ItemTax->getBypiID( $value['piID'] );
            }
        }
        return $list;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBypiID( $piID ) {
        return $this->ItemTax->getBypiID( $piID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['piID'] ) ) {
            if( isset( $data['itemTaxGroup'] ) && is_array( $data['itemTaxGroup'] ) ) {
                $TaxModel = TaxModel::getInstance( );

                // Make sure all itemTaxGroup are valid
                if( $TaxModel->existByTGIDs( $data['itemTaxGroup'] ) ) {
                    $this->ItemTax->delete('payroll_item_tax', 'WHERE piID = "' . (int)$data['piID'] . '"');

                    $saveInfo = array( );
                    foreach( $data['itemTaxGroup'] as $tgID ) {
                        $saveInfo['piID'] = (int)$data['piID'];
                        $saveInfo['tgID'] = (int)$tgID;
                        $this->ItemTax->insert( 'payroll_item_tax', $saveInfo );
                    }
                }
            }
            // If no itemTaxGroup is pass in, delete any existing data
            else {
                $this->ItemTax->delete('payroll_item_tax', 'WHERE piID = "' . (int)$data['piID'] . '"');
            }
        }
    }
}
?>