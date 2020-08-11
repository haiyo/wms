<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PayrollView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayslipView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $PayslipModel;


    /**
    * PayslipView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->PayslipModel = PayslipModel::getInstance( );

        $this->View->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                        'markaxis' => 'payslip.js' ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderPayslipList( ) {
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-download',
                                            'text' => $this->L10n->getContents('LANG_VIEW_DOWNLOAD_PAYSLIPS') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( ) );

        $this->View->printAll( $this->View->render( 'markaxis/payroll/payslipList.tpl', $vars ) );
    }
}
?>