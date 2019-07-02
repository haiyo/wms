<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry, \Library\Util\Date;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EmployeeView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $EmployeeModel;


    /**
    * EmployeeView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/EmployeeRes');

        $this->EmployeeModel = EmployeeModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderProcessForm( $empInfo ) {
        if( $empInfo ) {
            $titleValue = $empInfo['name'];

            if( $empInfo['birthday'] ) {
                $titleValue .= ' (' . Date::getAge( $empInfo['birthday'] ) . ')';
            }
            $vars = array_merge( $this->L10n->getContents( ),
                    array( 'TPLVAR_TITLE_KEY' => $this->L10n->getContents('LANG_EMPLOYEE'),
                           'TPLVAR_TITLE_VALUE' => $titleValue ) );

            $vars['dynamic']['list'][] = array( 'TPLVAR_KEY' => $this->L10n->getContents('LANG_DESIGNATION'),
                                                'TPLVAR_VALUE' => $empInfo['designation'] );

            $vars['dynamic']['list'][] = array( 'TPLVAR_KEY' => $this->L10n->getContents('LANG_CONTRACT_TYPE'),
                                                'TPLVAR_VALUE' => $empInfo['contractType'] );

            $vars['dynamic']['list'][] = array( 'TPLVAR_KEY' => $this->L10n->getContents('LANG_WORK_PASS'),
                                                'TPLVAR_VALUE' => $empInfo['passType'] ? $empInfo['passType'] : $empInfo['nationality'] );

            $col_1 = $this->View->render( 'markaxis/payroll/processHeader.tpl', $vars );

            $vars = array_merge( $this->L10n->getContents( ),
                    array( 'TPLVAR_TITLE_KEY' => $this->L10n->getContents('LANG_EMPLOYEE_ID'),
                           'TPLVAR_TITLE_VALUE' => $empInfo['idnumber'] ) );

            $duration = '';
            if( $empInfo['startDate'] ) {
                $duration = ' (';
                $dateDiff = \DateTime::createFromFormat('jS M Y',
                            $empInfo['startDate'] )->diff( new \DateTime('now') );

                if( $dateDiff->y ) {
                    $duration .= $dateDiff->y . $this->L10n->getContents('LANG_DIFF_YEAR') . ' ';
                }
                if( $dateDiff->m ) {
                    $duration .= $dateDiff->m . $this->L10n->getContents('LANG_DIFF_MONTH') . ' ';
                }
                if( $dateDiff->d ) {
                    $duration .= $dateDiff->d . $this->L10n->getContents('LANG_DIFF_DAY');
                }
                $duration .= ')';
            }

            $vars['dynamic']['list'][] = array( 'TPLVAR_KEY' => $this->L10n->getContents('LANG_EMPLOYMENT_START_DATE'),
                                                'TPLVAR_VALUE' => $empInfo['startDate'] ? $empInfo['startDate'] . $duration : '--' );

            $vars['dynamic']['list'][] = array( 'TPLVAR_KEY' => $this->L10n->getContents('LANG_EMPLOYMENT_END_DATE'),
                                                'TPLVAR_VALUE' => $empInfo['endDate'] ? $empInfo['endDate'] : '--' );

            $vars['dynamic']['list'][] = array( 'TPLVAR_KEY' => $this->L10n->getContents('LANG_EMPLOYMENT_CONFIRM_DATE'),
                                                'TPLVAR_VALUE' => $empInfo['confirmDate'] ? $empInfo['confirmDate'] : '--' );

            $col_2 = $this->View->render( 'markaxis/payroll/processHeader.tpl', $vars );

            return array( 'col_1' => $col_1, 'col_2' => $col_2 );
        }
    }
}
?>