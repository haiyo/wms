<?php
namespace Markaxis\Payroll;
use \Aurora\AuroraView;
use \Library\IO\File;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PayrollView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $PayrollModel;


    /**
    * PayrollView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        File::import( MODEL . 'Markaxis/Payroll/PayrollModel.class.php' );
        $PayrollModel = PayrollModel::getInstance( );
        $this->PayrollModel = $PayrollModel;

        $this->setJScript( array( 'plugins/visualization' => 'echarts/echarts.min.js',
                                  'plugins/moment' => 'moment.min.js',
                                  'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                  'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                  'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                  'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js', 'widgets.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderOverview( ) {
        $vars = array( );

        $dataDays = '';
        $month = date('n');
        $year  = date('Y' );
        $nDays = cal_days_in_month(CAL_GREGORIAN, $month, $year ); // 31

        for( $i=1; $i<=$nDays; $i++ ) {
            $dataDays .= "'$year/$month/$i',";
        }

        $vars['TPLVAR_DATA_DAYS'] = $dataDays;

        $this->setBreadcrumbs( array( 'link' => '',
                                      'icon' => 'icon-stats-bars2',
                                      'text' => $this->L10n->getContents('LANG_PAYROLL_OVERVIEW') ) );
        return $this->render( 'markaxis/payroll/overview.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderSettings( $form ) {
        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_FORM' => $form ) );

        $this->setBreadcrumbs( array( 'link' => '',
                                      'icon' => 'icon-cog2',
                                      'text' => $this->L10n->getContents('LANG_PAYROLL_SETTINGS') ) );

        return $this->render( 'markaxis/payroll/settings.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderProcess( ) {
        $vars = array_merge( $this->L10n->getContents( ), array( ) );

        $this->setBreadcrumbs( array( 'link' => '',
            'icon' => 'icon-cog2',
            'text' => $this->L10n->getContents('LANG_PROCESS_PAYROLL') ) );

        return $this->render( 'markaxis/payroll/payruns.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAllByID( $data ) {
        $vars = array( );
        $vars['bool'] = 0;
        $vars['dynamic']['monthly'] = false;

        if( isset( $data['ids'] ) && $info = $this->PayrollModel->getAllByID( $data['ids'] ) ) {
            foreach( $info as $key => $value ) {
                if( isset( $value['name'] ) ) {
                    $vars['dynamic']['monthly'][] = array( 'TPLVAR_IDNUMBER' => $value['idnumber'],
                                                           'TPLVAR_NAME' => $value['name'],
                                                           'TPLVAR_POSITION' => $value['position'] );
                }
            }
        }
        $vars['bool'] = 1;
        $vars['html'] = $this->render( 'markaxis/payroll/selectItem.tpl', $vars );
        return json_encode( $vars );
    }
}
?>