<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
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
        $this->View->setJScript( array( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ), array( ) );

        return $this->View->render( 'markaxis/payroll/itemList.tpl', $vars );
    }
}
?>