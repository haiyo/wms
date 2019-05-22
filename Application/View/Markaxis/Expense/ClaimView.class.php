<?php
namespace Markaxis\Expense;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Component\CurrencyModel;
use \Library\Runtime\Registry, \Library\Util\Date;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ClaimView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ClaimView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $ClaimModel;


    /**
    * ClaimView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->ClaimModel = ClaimModel::getInstance( );

        $this->setJScript( array( 'plugins/moment' => 'moment.min.js',
                                  'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                  'plugins/forms' => array( 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                  'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                  'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                  'plugins/uploaders' => array( 'fileinput.min.js' ),
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js', 'widgets.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderClaimList( ) {
        $this->setBreadcrumbs( array( 'link' => '',
                                      'icon' => 'icon-coins',
                                      'text' => $this->L10n->getContents('LANG_EXPENSES_CLAIM') ) );

        $ExpenseModel = ExpenseModel::getInstance( );
        $CurrencyModel = CurrencyModel::getInstance( );

        $SelectListView = new SelectListView( );
        $currencyList = $SelectListView->build( 'currency', $CurrencyModel->getList( ), '', 'Currency' );
        $expenseList  = $SelectListView->build( 'expense', $ExpenseModel->getList( ), '', 'Select Expense Type' );

        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_CURRENCY_LIST' => $currencyList,
                                                                 'TPLVAR_EXPENSE_LIST' => $expenseList ) );

        $this->setJScript( array( 'markaxis' => array( 'usuggest.js' ),
                                  'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js',
                                                            'input/typeahead.bundle.min.js', 'input/handlebars.js' ) ) );

        return $this->render( 'markaxis/expense/claimList.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderPendingAction( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $pendingAction = $this->ClaimModel->getPendingAction( $userInfo['userID'] );

        if( $pendingAction ) {
            $vars = array_merge( $this->L10n->getContents( ), array( ) );

            foreach( $pendingAction as $row ) {
                $created = Date::timeSince( $row['created'] );

                $vars['dynamic']['list'][] = array( 'TPLVAR_FNAME' => $row['fname'],
                                                    'TPLVAR_LNAME' => $row['lname'],
                                                    'TPLVAR_TIME_AGO' => $created,
                                                    'TPLVAR_TITLE' => $row['itemTitle'],
                                                    'TPLVAR_DESCRIPTION' => $row['descript'] );

                return $this->render( 'aurora/page/tableRowRequest.tpl', $vars );
            }
        }
    }
}
?>