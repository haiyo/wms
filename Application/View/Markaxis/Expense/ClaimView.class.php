<?php
namespace Markaxis\Expense;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Component\CurrencyModel, \Aurora\User\UserModel, \Aurora\User\UserImageModel;
use \Library\Runtime\Registry, \Library\Util\Date;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ClaimView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ClaimView {


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
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->ClaimModel = ClaimModel::getInstance( );

        $this->View->setJScript( array( 'plugins/moment' => 'moment.min.js',
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                        'plugins/forms' => array( 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                        'plugins/uploaders' => array( 'fileinput.min.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderClaimList( ) {
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-coins',
                                            'text' => $this->L10n->getContents('LANG_EXPENSES_CLAIM') ) );

        $ExpenseModel = ExpenseModel::getInstance( );
        $CurrencyModel = CurrencyModel::getInstance( );

        $SelectListView = new SelectListView( );
        $currencyList = $SelectListView->build( 'currency', $CurrencyModel->getList( ), '', 'Currency' );
        $expenseList  = $SelectListView->build( 'expense', $ExpenseModel->getList( ), '', 'Select Expense Type' );

        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_CURRENCY_LIST' => $currencyList,
                                                                 'TPLVAR_EXPENSE_LIST' => $expenseList ) );

        $this->View->setJScript( array( 'markaxis' => array( 'usuggest.js', 'claim.js' ),
                                        'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js',
                                                                  'input/typeahead.bundle.min.js', 'input/handlebars.js' ) ) );

        $this->View->printAll( $this->View->render( 'markaxis/expense/claimList.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderPendingAction( ) {
        $userInfo = UserModel::getInstance( )->getInfo( );

        $pendingAction = $this->ClaimModel->getPendingAction( $userInfo['userID'] );

        if( $pendingAction ) {
            $vars = array_merge( $this->L10n->getContents( ), array( ) );

            foreach( $pendingAction as $row ) {
                $created = Date::timeSince( $row['created'] );

                $attachment = '';
                if( $row['uID'] ) {
                    $attachment = '<a target="_blank" href="' . ROOT_URL . 'admin/file/view/' . $row['uID'] .
                                    '/' . $row['hashName'] . '">' . $row['uploadName'] . '</a>';
                }
                $UserImageModel = UserImageModel::getInstance( );

                $vars['dynamic']['list'][] = array( 'TPLVAR_PHOTO' => $UserImageModel->getImgLinkByUserID( $row['userID'] ),
                                                    'TPLVAR_FNAME' => $row['fname'],
                                                    'TPLVAR_LNAME' => $row['lname'],
                                                    'TPLVAR_TIME_AGO' => $created,
                                                    'TPLVAR_ID' => $row['ecID'],
                                                    'TPLVAR_GROUP_NAME' => 'claim',
                                                    'TPLVAR_CLASS' => 'claimAction',
                                                    'TPLVAR_TITLE' => $row['itemTitle'],
                                                    'TPLVAR_DESCRIPTION' => $row['descript'],
                                                    'TPLVAR_VALUE' => $row['currencyCode'] . $row['currencySymbol'] . $row['amount'],
                                                    'TPLVAR_ATTACHMENT' => $attachment );

                return $this->View->render( 'aurora/page/tableRowPending.tpl', $vars );
            }
        }
    }
}
?>