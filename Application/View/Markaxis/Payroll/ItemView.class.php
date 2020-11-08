<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
use \Aurora\Form\RadioView;
use \Library\Helper\Markaxis\ItemCategoryHelper;
use \Library\Helper\Markaxis\AllowanceTypeHelper;
use \Library\Helper\Markaxis\LumpSumTypeHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ItemView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $ItemModel;


    /**
    * ItemView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->ItemModel = ItemModel::getInstance( );

        $this->View->setJScript( array( 'markaxis' => 'payItem.js' ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $RadioView = new RadioView( );
        $categoryRadio = $RadioView->build('category', ItemCategoryHelper::getL10nList( ), 'n' );
        $allowanceTypeRadio = $RadioView->build('allowanceType', AllowanceTypeHelper::getL10nList( ), 'o' );
        $lumpSumTypeRadio = $RadioView->build('lumpSumType', LumpSumTypeHelper::getL10nList( ), 'g' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_ALLOWANCE_BENEFITS_STOCKS' => $categoryRadio,
                       'TPLVAR_ALLOWANCE_TYPE' => $allowanceTypeRadio,
                       'TPLVAR_LUMP_SUM_TYPE' => $lumpSumTypeRadio ) );

        return $this->View->render( 'markaxis/payroll/itemList.tpl', $vars );
    }
}
?>