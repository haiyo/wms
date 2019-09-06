<?php
namespace Markaxis\Leave;
use \Aurora\Admin\AdminView, \Aurora\Form\RadioView, \Aurora\Form\SelectListView;
use \Library\Helper\Aurora\YesNoHelper;
use \Library\Helper\Markaxis\HalfDayHelper, \Library\Helper\Markaxis\PaidLeaveHelper;
use \Library\Helper\Markaxis\UnusedLeaveHelper;
use \Library\Helper\Markaxis\LeavePeriodHelper, \Library\Helper\Markaxis\CarryPeriodHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: HolidayView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HolidayView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $HolidayModel;


    /**
    * TypeView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->HolidayModel = HolidayModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( ) );

        return $this->View->render( 'markaxis/leave/holidayList.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAddType( ) {
        $this->info = $this->TypeModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEditType( $ltID ) {
        if( $this->info = $this->TypeModel->getByID( $ltID ) ) {
            return $this->renderForm( );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( ) {
        $RadioView = new RadioView( );
        $allowHalfDayRadio = $RadioView->build('allowHalfDay', HalfDayHelper::getL10nList( ), $this->info['allowHalfDay'] );
        $showChartRadio = $RadioView->build('showChart', YesNoHelper::getL10nList( ), $this->info['showChart'] );

        $SelectListView = new SelectListView( );
        $paidLeaveList  = $SelectListView->build('paidLeave', PaidLeaveHelper::getL10nList( ), $this->info['paidLeave'] );
        $unusedList     = $SelectListView->build('unused', UnusedLeaveHelper::getL10nList( ), $this->info['unused'] );

        $SelectListView->isDisabled( true );
        $cPeriodList = $SelectListView->build('cPeriodType', CarryPeriodHelper::getL10nList( ), $this->info['cPeriodType'], $this->L10n->getContents('LANG_SELECT_PERIOD') );
        $usedPeriodList  = $SelectListView->build('usedType', LeavePeriodHelper::getL10nList( ), $this->info['uPeriodType'], $this->L10n->getContents('LANG_SELECT_PERIOD') );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_LEAVE_TYPE_NAME' => $this->info['name'],
                       'TPLVAR_LEAVE_TYPE_CODE' => $this->info['code'],
                       'TPLVAR_CPERIOD' => $this->info['cPeriod'],
                       'TPLVAR_UPERIOD' => $this->info['uPeriod'],
                       'TPLVAR_PAYROLL_FORMULA' => $this->info['formula'],
                       'TPL_ALLOW_HALF_DAY_RADIO' => $allowHalfDayRadio,
                       'TPL_SHOW_CHART_RADIO' => $showChartRadio,
                       'TPL_PAID_LEAVE' => $paidLeaveList,
                       'TPL_UNUSED_LIST' => $unusedList,
                       'TPL_CPERIOD_LIST' => $cPeriodList,
                       'TPL_USED_PERIOD_LIST' => $usedPeriodList ) );

        return $this->View->render( 'markaxis/leave/typeForm.tpl', $vars );
    }
}
?>