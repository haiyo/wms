<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\LeaveBalanceModel;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $LeaveModel;


    /**
    * EmployeeView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/LeaveRes');
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderProcessForm( $userID ) {
        $LeaveBalanceModel = LeaveBalanceModel::getInstance( );

        if( $lvInfo = $LeaveBalanceModel->getByUserID( $userID, 3 ) ) {
            $vars = array_merge( $this->L10n->getContents( ),
                    array( 'TPLVAR_TITLE_KEY' => $this->L10n->getContents('LANG_LEAVE_BALANCE'),
                           'TPLVAR_TITLE_VALUE' => '' ) );

            foreach( $lvInfo as $row ) {
                $vars['dynamic']['list'][] = array( 'TPLVAR_KEY' => $row['name'],
                                                    'TPLVAR_VALUE' => $row['balance'] );
            }
            $col_3 = $this->render( 'markaxis/payroll/processHeader.tpl', $vars );
            return array( 'col_3' => $col_3 );
        }
    }
}
?>