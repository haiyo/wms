<?php
namespace Markaxis\Employee;
use \Aurora\AuroraView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TimesheetView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TimesheetView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TimesheetModel;
    protected $info;


    /**
    * TimesheetView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/EmployeeRes');

        $this->TimesheetModel = TimesheetModel::getInstance( );

        $this->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js'),
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js', 'widgets.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderList( ) {
        $this->setBreadcrumbs( array( 'link' => 'admin/employee/timesheet',
                                      'icon' => 'icon-alarm',
                                      'text' => $this->L10n->getContents('LANG_EMPLOYEE_TIMESHEET') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( 'LANG_LINK' => $this->L10n->getContents('LANG_EMPLOYEE_TIMESHEET') ) );

        return $this->render( 'markaxis/employee/timesheet.tpl', $vars );
    }
}
?>