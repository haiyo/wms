<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ItemView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemView extends AdminView {


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
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->ItemModel = ItemModel::getInstance( );

        $this->setJScript( array( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $SelectListView = new SelectListView( );
        $SelectListView->isMultiple( true );
        $SelectListView->includeBlank( false );

        $TaxGroupModel = TaxGroupModel::getInstance( );

        //$taxGroup = isset( $taxInfo['tgID'] ) ? explode(',', $taxInfo['tgID'] ) : '';
        $taxGroupList = $SelectListView->build( 'itemTaxGroup', $TaxGroupModel->getList( ), '', 'Select Tax Group' );

        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_TAX_GROUP_LIST' => $taxGroupList ) );

        return $this->render( 'markaxis/payroll/items.tpl', $vars );
    }
}
?>