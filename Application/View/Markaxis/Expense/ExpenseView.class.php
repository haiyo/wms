<?php
namespace Markaxis\Expense;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Component\CountryModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ExpenseView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseView {


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
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->ExpenseModel = ExpenseModel::getInstance( );

        $this->View->setJScript( array( 'plugins/visualization' => 'echarts/echarts.min.js',
                                        'plugins/moment' => 'moment.min.js',
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                        'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ),
                                        'markaxis' => 'expense.js' ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $SelectListView = new SelectListView( );
        $SelectListView->includeBlank(false);
        $SelectListView->isMultiple(false);

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );
        $countryList = $SelectListView->build( 'expenseCountry', $countries, '', $this->L10n->getContents('LANG_SELECT_COUNTRY') );

        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_COUNTRY_LIST' => $countryList ) );

        return $this->View->render( 'markaxis/expense/expenseList.tpl', $vars );
    }
}
?>