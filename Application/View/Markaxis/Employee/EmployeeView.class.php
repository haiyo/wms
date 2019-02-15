<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView, \Aurora\Component\DesignationModel, \Aurora\Form\SelectGroupListView;
use \Aurora\Form\DayIntListView, \Aurora\Form\SelectListView;
use \Library\Helper\Aurora\MonthHelper, \Library\Helper\Aurora\CurrencyHelper, \Aurora\Component\SalaryTypeModel;
use \Aurora\Component\OfficeModel, \Aurora\Component\ContractModel, \Aurora\Component\PassTypeModel;
use \Aurora\User\UserRoleModel, \Aurora\User\RoleModel;
use \Aurora\Component\DepartmentModel as A_DepartmentModel;
use \Markaxis\Employee\DepartmentModel as M_DepartmentModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EmployeeView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $EmployeeModel;
    protected $info;


    /**
    * EmployeeView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/EmployeeRes');

        $this->EmployeeModel = EmployeeModel::getInstance( );

        $this->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js'),
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderList( ) {
        $this->setBreadcrumbs( array( 'link' => 'admin/employee/list',
                                      'icon' => 'icon-users4',
                                      'text' => $this->L10n->getContents('LANG_STAFF_DIRECTORY') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( 'LANG_LINK' => $this->L10n->getContents('LANG_STAFF_DIRECTORY') ) );

        return $this->render( 'markaxis/employee/list.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderView( ) {
        $vars = array( 'LANG_LINK' => $this->L10n->getContents('LANG_STAFF_DIRECTORY') );

        return $this->render( 'markaxis/employee/view.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAdd( ) {
        $this->info = $this->EmployeeModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderEdit( $userID ) {
        if( $this->info = $this->EmployeeModel->getFieldByUserID( $userID, '*' ) ) {
            return $this->renderForm( );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderForm( ) {
        $DayIntListView = new DayIntListView( );
        $SelectListView = new SelectListView( );

        $confirmDay = $confirmMonth = $confirmYear = $startDay = $startMonth = $startYear =
        $endDay = $endMonth = $endYear = $passExpiryDay = $passExpiryMonth = $passExpiryYear = '';

        if( $this->info['confirmDate'] ) {
            $confirmDate = explode( '-', $this->info['confirmDate'] );
            $confirmDay   = $confirmDate[2];
            $confirmMonth = $confirmDate[1];
            $confirmYear  = $confirmDate[0];
        }

        if( $this->info['startDate'] ) {
            $startDate = explode( '-', $this->info['startDate'] );
            $startDay   = $startDate[2];
            $startMonth = $startDate[1];
            $startYear  = $startDate[0];
        }

        if( $this->info['endDate'] ) {
            $endDate = explode( '-', $this->info['endDate'] );
            $endDay   = $endDate[2];
            $endMonth = $endDate[1];
            $endYear  = $endDate[0];
        }

        if( $this->info['passExpiryDate'] ) {
            $passExpiry = explode( '-', $this->info['passExpiryDate'] );
            $passExpiryDay = $passExpiry[2];
            $passExpiryMonth = $passExpiry[1];
            $passExpiryYear  = $passExpiry[0];
        }

        $DesignationModel = DesignationModel::getInstance( );

        $SelectGroupListView = new SelectGroupListView( );
        $pID = isset( $this->info['pID'] ) ? $this->info['pID'] : '';
        $designationList = $SelectGroupListView->build( 'designation', $DesignationModel->getList( ), $pID, 'Select Designation' );

        $confirmDayList   = $DayIntListView->getList( 'confirmDay', $confirmDay, 'Day' );
        $confirmMonthList = $SelectListView->build( 'confirmMonth', MonthHelper::getL10nList( ), $confirmMonth, 'Month' );

        $startDayList   = $DayIntListView->getList( 'startDay', $startDay, 'Day' );
        $startMonthList = $SelectListView->build( 'startMonth', MonthHelper::getL10nList( ), $startMonth, 'Month' );

        $endDayList   = $DayIntListView->getList( 'endDay', $endDay, 'Day' );
        $endMonthList = $SelectListView->build( 'endMonth', MonthHelper::getL10nList( ), $endMonth, 'Month' );

        $passExpiryDayList   = $DayIntListView->getList( 'passExpiryDay', $passExpiryDay, 'Day' );
        $passExpiryMonthList = $SelectListView->build( 'passExpiryMonth', MonthHelper::getL10nList( ), $passExpiryMonth, 'Month' );

        $currencyList = $SelectListView->build( 'currency', CurrencyHelper::getL10nList( ), $this->info['currency'], 'Currency' );

        $SalaryTypeModel = SalaryTypeModel::getInstance( );
        $stID = isset( $this->info['stID'] ) ? $this->info['stID'] : '';
        $SelectListView->setClass( 'salaryTypeList' );
        $salaryTypeList = $SelectListView->build( 'salaryType',  $SalaryTypeModel->getList( ), $stID, 'Salary Rate Type' );

        $OfficeModel = OfficeModel::getInstance( );
        $oID = isset( $this->info['oID'] ) ? $this->info['oID'] : '';
        $officeList = $SelectListView->build( 'office',  $OfficeModel->getList( ), $oID, 'Select Office / Location' );

        $ContractModel = ContractModel::getInstance( );
        $cID = isset( $this->info['cID'] ) ? $this->info['cID'] : '';
        $contractList = $SelectListView->build( 'contractType',  $ContractModel->getList( ), $cID, 'Select Contract Type' );

        $PassTypeModel = PassTypeModel::getInstance( );
        $ptID = isset( $this->info['ptID'] ) ? $this->info['ptID'] : '';
        $passTypeList = $SelectGroupListView->build( 'passType',  $PassTypeModel->getList( ), $ptID, 'Select Pass Type' );

        $UserRoleModel = UserRoleModel::getInstance( );
        $RoleModel = RoleModel::getInstance( );
        $SelectListView->isMultiple( true );
        $selectedRole = $this->info['userID'] ? $UserRoleModel->getByUserID( $this->info['userID'] ) : '';
        $roleList = $SelectListView->build( 'role',  $RoleModel->getList( ), $selectedRole, 'Select Role(s)' );

        $SupervisorModel = SupervisorModel::getInstance( );
        $supervisors = $this->info['userID'] ? $SupervisorModel->getNameByUserID( $this->info['userID'] ) : '';

        $ComponentDepartmentModel = A_DepartmentModel::getInstance( );

        $DepartmentModel = M_DepartmentModel::getInstance( );

        $departmentList = $SelectListView->build( 'department',  $ComponentDepartmentModel->getList( ),
                                                    $DepartmentModel->getByUserID( $this->info['userID'] ), 'Select Department' );

        $CompetencyModel = CompetencyModel::getInstance( );
        $competencyList = $CompetencyModel->getByUserID( $this->info['userID'] );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_IDNUMBER' => $this->info['idnumber'],
                       'TPLVAR_CONFIRM_YEAR' => $confirmYear,
                       'TPLVAR_START_YEAR' => $startYear,
                       'TPLVAR_END_YEAR' => $endYear,
                       'TPLVAR_PASS_EXPIRY_YEAR' => $passExpiryYear,
                       'TPLVAR_SALARY' => $this->info['salary'],
                       'TPLVAR_PASS_NUMBER' => $this->info['passNumber'],
                       'TPLVAR_SUPERVISORS' => isset( $supervisors['name'] ) ? $supervisors['name'] : '',
                       'TPLVAR_COMPETENCY' => $competencyList['competency'],
                       'TPL_OFFICE_LIST' => $officeList,
                       'TPL_DEPARTMENT_LIST' => $departmentList,
                       'TPL_DESIGNATION_LIST' => $designationList,
                       'TPL_CONTRACT_LIST' => $contractList,
                       'TPL_PASS_TYPE_LIST' => $passTypeList,
                       'TPL_CURRENCY_LIST' => $currencyList,
                       'TPL_SALARY_TYPE' => $salaryTypeList,
                       'TPL_ROLE_LIST' => $roleList,
                       'TPL_CONFIRM_MONTH_LIST' => $confirmMonthList,
                       'TPL_CONFIRM_DAY_LIST' => $confirmDayList,
                       'TPL_START_MONTH_LIST' => $startMonthList,
                       'TPL_START_DAY_LIST' => $startDayList,
                       'TPL_END_MONTH_LIST' => $endMonthList,
                       'TPL_END_DAY_LIST' => $endDayList,
                       'TPL_PASS_EXPIRY_MONTH_LIST' => $passExpiryMonthList,
                       'TPL_PASS_EXPIRY_DAY_LIST' => $passExpiryDayList ) );

        return $this->render( 'markaxis/employee/employeeForm.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderLog( $userID ) {
        $vars = array( 'TPLVAR_USERID' => $userID );
        return $this->render( 'markaxis/employee/log.tpl', $vars );
    }
}
?>