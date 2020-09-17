<?php
namespace Markaxis\Expense;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\User\UserImageModel;
use \Library\Util\Money;
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
    protected $GlobalRes;
    protected $ExpenseRes;
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
        $this->ExpenseRes = $this->i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->ClaimModel = ClaimModel::getInstance( );

        $this->View->setJScript( array( 'plugins/moment' => 'moment.min.js',
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                        'plugins/forms' => array( 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                        'plugins/uploaders' => array( 'fileinput.min.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ),
                                        'locale' => $this->ExpenseRes->getL10n( ) ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderClaimList( ) {
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-coins',
                                            'text' => $this->ExpenseRes->getContents('LANG_EXPENSES_CLAIM') ) );

        $ExpenseModel = ExpenseModel::getInstance( );

        $SelectListView = new SelectListView( );
        $expenseList  = $SelectListView->build( 'expense', $ExpenseModel->getList( ), '', $this->ExpenseRes->getContents('LANG_SELECT_EXPENSE_TYPE') );

        $vars = array_merge( $this->ExpenseRes->getContents( ), array( 'TPLVAR_EXPENSE_LIST' => $expenseList ) );

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
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $pendingAction = $this->ClaimModel->getPendingAction( $userInfo['userID'] );

        if( $pendingAction ) {
            $vars = array_merge( $this->ExpenseRes->getContents( ), array( ) );

            foreach( $pendingAction as $row ) {
                $created = Date::timeSince( $row['created'] );

                $attachment = '';
                if( $row['uID'] ) {
                    $attachment = '<a target="_blank" href="' . ROOT_URL . 'admin/file/view/claim/' . $row['uID'] .
                                    '/' . $row['hashName'] . '"><i class="icon-attachment text-grey-300 mr-3"></i> ' . $row['uploadName'] . '</a>';
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
                                                    'TPLVAR_VALUE' => $row['currencyCode'] . $row['currencySymbol'] . Money::format( $row['amount'] ),
                                                    'TPLVAR_ATTACHMENT' => $attachment );
            }
            return $this->View->render( 'aurora/page/tableRowPending.tpl', $vars );
        }
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderRequest( $request ) {
        if( is_array( $request ) ) {
            $vars = array_merge( $this->ExpenseRes->getContents( ), array( ) );

            foreach( $request as $row ) {
                $created = Date::timeSince( $row['created'] );

                if( $row['status'] == 0 ) {
                    $label = 'pending';
                    $status = $this->View->getGlobalRes( )->getContents('LANG_PENDING');
                }
                else if( $row['status'] == 1 ) {
                    $label = 'success';
                    $status = $this->View->getGlobalRes( )->getContents('LANG_APPROVED');
                }
                else {
                    $label = 'danger';
                    $status = $this->View->getGlobalRes( )->getContents('LANG_UNAPPROVED');
                }

                $managers = '';

                if( isset( $row['managers'] ) ) {
                    foreach( $row['managers'] as $manager ) {
                        if( $manager['approved'] == 0 ) {
                            $managers .= '<i class="icon-watch2 text-grey-300 mr-3"></i>';
                        }
                        else if( $manager['approved'] == 1 ) {
                            $managers .= '<i class="icon-checkmark4 text-green-800 mr-3"></i>';
                        }
                        else if( $manager['approved'] == "-1" ) {
                            $managers .= '<i class="icon-cross2 text-warning-800 mr-3"></i>';
                        }
                        $managers .= $manager['name'] . '<br />';
                    }
                }

                $attachment = '';
                if( $row['uID'] ) {
                    $attachment = '<a target="_blank" href="' . ROOT_URL . 'admin/file/view/claim/' . $row['uID'] .
                        '/' . $row['hashName'] . '"><i class="icon-attachment text-grey-300 mr-3"></i> ' . $row['uploadName'] . '</a>';
                }

                $vars['dynamic']['list'][] = array( 'TPLVAR_FNAME' => $row['fname'],
                                                    'TPLVAR_LNAME' => $row['lname'],
                                                    'TPLVAR_TIME_AGO' => $created,
                                                    'TPLVAR_ID' => $row['ecID'],
                                                    'TPLVAR_GROUP_NAME' => 'claim',
                                                    'TPLVAR_CLASS' => 'claimCancel',
                                                    'TPLVAR_TITLE' => $row['itemTitle'],
                                                    'TPLVAR_DESCRIPTION' => $row['descript'],
                                                    'TPLVAR_VALUE' => $row['currencyCode'] . $row['currencySymbol'] . Money::format( $row['amount'] ),
                                                    'TPLVAR_LABEL' => $label,
                                                    'TPLVAR_MANAGER' => $managers,
                                                    'TPLVAR_ATTACHMENT' => $attachment,
                                                    'LANG_STATUS' => $status );
            }
            return $this->View->render( 'aurora/page/tableRowRequest.tpl', $vars );
        }
    }
}
?>