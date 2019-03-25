<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Library\Helper\Markaxis\RecurHelper;
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
     * @return str
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ), array( ) );

        return $this->render( 'markaxis/payroll/items.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderEndDate( $data ) {
        if( $DateTime = $this->CalendarModel->getEndDate( $data ) ) {
            $str = $this->L10n->getContents( 'LANG_STARTDATE_HELP' );
            $str = str_replace( '{endDate}', $DateTime->format('jS M Y'), $str );
            $str = str_replace( '{payPeriod}', $data['payPeriod'], $str );
            return $str;
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderPaymentRecur( $data ) {
        if( $range = $this->CalendarModel->getPaymentRecur( $data ) ) {
            $str = $this->L10n->getContents( 'LANG_FIRST_PAYMENT_HELP' );
            $str = str_replace( '{dates}', implode( ', ', $range ), $str );
            return $str;
        }
    }
}
?>