<?php
namespace Markaxis\Payroll;
use \Aurora\Component\OfficeModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Library\Helper\Markaxis\RecurHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalendarView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarView {


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
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->CalendarModel = CalendarModel::getInstance( );

        $this->View->setJScript( array( 'markaxis' => 'payCal.js' ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $SelectListView = new SelectListView( );

        /*$OfficeModel = OfficeModel::getInstance( );
        $officeList = $SelectListView->build( 'office', $OfficeModel->getList( ), '',
                                              $this->L10n->getContents('LANG_SELECT_OFFICE') );*/

        $recurList = RecurHelper::getL10nList( );
        unset( $recurList['day'] );
        unset( $recurList['year'] );
        unset( $recurList['week'] );
        unset( $recurList['biweekly'] );
        unset( $recurList['weekday'] );
        unset( $recurList['monWedFri'] );
        unset( $recurList['tueThur'] );
        $periodList = $SelectListView->build( 'payPeriod',  $recurList, '' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_PAY_PERIOD_LIST' => $periodList ) );

        return $this->View->render( 'markaxis/payroll/calendar.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
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
     * @return string
     */
    public function renderPaymentRecur( $data ) {
        if( $range = $this->CalendarModel->getPaymentRecur( $data ) ) {
            //$str = $this->L10n->getContents( 'LANG_FIRST_PAYMENT_HELP' );
            //$str = str_replace( '{dates}', implode( ', ', $range ), $str );
            return implode( ', ', $range );
        }
    }
}
?>