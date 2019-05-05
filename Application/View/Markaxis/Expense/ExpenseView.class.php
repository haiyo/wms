<?php
namespace Markaxis\Expense;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Library\Helper\Aurora\CurrencyHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ExpenseView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $ExpenseModel;


    /**
    * ExpenseView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->ExpenseModel = ExpenseModel::getInstance( );

        $this->setJScript( array( 'plugins/visualization' => 'echarts/echarts.min.js',
                                  'plugins/moment' => 'moment.min.js',
                                  'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                  'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                  'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                  'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js', 'widgets.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $SelectListView = new SelectListView( );
        $currencyList = $SelectListView->build( 'currency', CurrencyHelper::getL10nList( ), '', 'Currency' );
        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_CURRENCY_LIST' => $currencyList ) );

        return $this->render( 'markaxis/expense/expenseList.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderClaimList( ) {
        $vars = array( );

        $this->setBreadcrumbs( array( 'link' => '',
                                      'icon' => 'icon-coins',
                                      'text' => $this->L10n->getContents('LANG_EXPENSES_CLAIM') ) );

        $vars = array_merge( $this->L10n->getContents( ), $vars );

        return $this->render( 'markaxis/expense/claimList.tpl', $vars );
    }
}
?>