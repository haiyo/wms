<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Library\Helper\Markaxis\RecurHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalendarView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $CalendarModel;


    /**
    * CalendarView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $CalendarModel = CalendarModel::getInstance( );
        $this->CalendarModel = $CalendarModel;

        $this->setJScript( array( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderSettings( ) {
        $SelectListView = new SelectListView( );
        $recurList = RecurHelper::getL10nList( );
        unset( $recurList['daily'] );
        unset( $recurList['yearly'] );
        unset( $recurList['weekday'] );
        unset( $recurList['monWedFri'] );
        unset( $recurList['tueThur'] );
        $periodList = $SelectListView->build( 'payPeriod',  $recurList, '' );

        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_PAY_PERIOD_LIST' => $periodList ) );

        return $this->render( 'markaxis/payroll/calendar.tpl', $vars );
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