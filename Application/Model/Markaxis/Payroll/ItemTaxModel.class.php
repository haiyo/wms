<?php
namespace Markaxis\Payroll;

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
}
?>