<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView, \Aurora\Component\DesignationModel, \Aurora\Form\SelectGroupListView;
use \Aurora\Form\DayIntListView, \Aurora\Form\SelectListView;
use \Library\Helper\Aurora\MonthHelper, \Library\Helper\Aurora\CurrencyHelper, \Aurora\Component\SalaryTypeModel;
use \Aurora\Component\OfficeModel, \Aurora\Component\ContractModel, \Aurora\Component\PassTypeModel;
use \Aurora\User\UserRoleModel, \Aurora\User\RoleModel;
use \Aurora\Component\DepartmentModel as A_DepartmentModel;
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

        // Get new instance!
        $this->EmployeeModel = new EmployeeModel( );

        $this->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js'),
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( $form ) {
        $this->setBreadcrumbs( array( 'link' => '',
                                      'icon' => 'icon-cog3',
                                      'text' => $this->L10n->getContents('LANG_EMPLOYEE_SETTINGS') ) );

        $vars = array( 'TPL_FORM' => $form );
        return $this->render( 'markaxis/employee/settings.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
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
     * @return string
     */
    public function renderCountList( $list ) {
        if( is_array( $list ) ) {
            $vars = array_merge( $this->L10n->getContents( ), array( ) );

            foreach( $list as $key => $value ) {
                $vars['dynamic']['list'][] = array( 'TPLVAR_IMAGE' => $value['image'],
                                                    'TPLVAR_FNAME' => $value['fname'],
                                                    'TPLVAR_LNAME' => $value['lname'],
                                                    'TPLVAR_EMAIL' => $value['email1'],
                                                    'TPLVAR_IDNUMBER' => $value['idnumber'],
                                                    'TPLVAR_DEPARTMENT' => $value['department'],
                                                    'TPLVAR_DESIGNATION' => $value['designation'] );
            }
            return $this->render( 'markaxis/employee/countList.tpl', $vars );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderView( ) {
        $vars = array( 'LANG_LINK' => $this->L10n->getContents('LANG_STAFF_DIRECTORY') );

        return $this->render( 'markaxis/employee/view.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAdd( ) {
        $this->info = $this->EmployeeModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $userID ) {
        if( $this->info = $this->EmployeeModel->getFieldByUserID( $userID, '*' ) ) {
            return $this->renderForm( );
        }
    }


    /**
     * Render main navigation
     * @return string
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
        $designationID = isset( $this->info['designationID'] ) ? $this->info['designationID'] : '';
        $designationList = $SelectGroupListView->build( 'designation', $DesignationModel->getList( ), $designationID, 'Select Designation' );

        $confirmDayList = $DayIntListView->getList( 'confirmDay', $confirmDay, 'Day' );
        $confirmMonthList = $SelectListView->build( 'confirmMonth', MonthHelper::getL10nList( ), $confirmMonth, 'Month' );

        $startDayList = $DayIntListView->getList( 'startDay', $startDay, 'Day' );
        $startMonthList = $SelectListView->build( 'startMonth', MonthHelper::getL10nList( ), $startMonth, 'Month' );

        $endDayList = $DayIntListView->getList( 'endDay', $endDay, 'Day' );
        $endMonthList = $SelectListView->build( 'endMonth', MonthHelper::getL10nList( ), $endMonth, 'Month' );

        $passExpiryDayList = $DayIntListView->getList( 'passExpiryDay', $passExpiryDay, 'Day' );
        $passExpiryMonthList = $SelectListView->build( 'passExpiryMonth', MonthHelper::getL10nList( ), $passExpiryMonth, 'Month' );
        $currencyList = $SelectListView->build( 'currency', CurrencyHelper::getL10nList( ), $this->info['currency'], 'Currency' );

        $SalaryTypeModel = SalaryTypeModel::getInstance( );
        $salaryTypeID = isset( $this->info['salaryTypeID'] ) ? $this->info['salaryTypeID'] : '';
        $SelectListView->setClass( 'salaryTypeList' );
        $salaryTypeList = $SelectListView->build( 'salaryType',  $SalaryTypeModel->getList( ), $salaryTypeID, 'Salary Type' );

        $OfficeModel = OfficeModel::getInstance( );
        $officeID = isset( $this->info['officeID'] ) ? $this->info['officeID'] : '';
        $officeList = $SelectListView->build( 'office',  $OfficeModel->getList( ), $officeID, 'Select Office / Location' );

        $ContractModel = ContractModel::getInstance( );
        $contractID = isset( $this->info['contractID'] ) ? $this->info['contractID'] : '';
        $contractList = $SelectListView->build( 'contractType',  $ContractModel->getList( ), $contractID, 'Select Contract Type' );

        $PassTypeModel = PassTypeModel::getInstance( );
        $passTypeID = isset( $this->info['passTypeID'] ) ? $this->info['passTypeID'] : '';
        $passTypeList = $SelectGroupListView->build( 'passType',  $PassTypeModel->getList( ), $passTypeID, 'Select Pass Type' );

        // === MULTI LIST LEVEL BELOW ===
        $SelectListView->isMultiple(true );
        $SelectListView->includeBlank(false);

        $UserRoleModel = UserRoleModel::getInstance( );
        $RoleModel = RoleModel::getInstance( );
        $selectedRole = $this->info['userID'] ? $UserRoleModel->getByUserID( $this->info['userID'] ) : '';
        $roleList = $SelectListView->build( 'role', $RoleModel->getList( ), $selectedRole, 'Select Role(s)' );

        $ManagerModel = ManagerModel::getInstance( );
        $managers = $this->info['userID'] ? $ManagerModel->getManagerToken( $this->info['userID'] ) : '';

        $CompetencyModel = CompetencyModel::getInstance( );
        $competencyList = $CompetencyModel->getByUserID( $this->info['userID'] );

        $A_DepartmentModel = A_DepartmentModel::getInstance( );
        $DepartmentModel = DepartmentModel::getInstance( );

        $SelectListView->setClass( '' );
        $departments = isset( $this->info['userID'] ) ? $DepartmentModel->getListByUserID( $this->info['userID'] ) : '';
        $departments = isset( $departments['dID'] ) ? explode(',', $departments['dID'] ) : '';
        $departmentList = $SelectListView->build( 'department',  $A_DepartmentModel->getList( ), $departments,'Select Department(s)' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_IDNUMBER' => $this->info['idnumber'],
                       'TPLVAR_CONFIRM_YEAR' => $confirmYear,
                       'TPLVAR_START_YEAR' => $startYear,
                       'TPLVAR_END_YEAR' => $endYear,
                       'TPLVAR_PASS_EXPIRY_YEAR' => $passExpiryYear,
                       'TPLVAR_SALARY' => number_format( $this->info['salary'] ),
                       'TPLVAR_PASS_NUMBER' => $this->info['passNumber'],
                       'TPLVAR_MANAGERS' => isset( $managers['name'] ) ? $managers['name'] : '',
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
     * @return string
     */
    public function renderLog( $userID ) {
        $vars = array( 'TPLVAR_USERID' => $userID );
        return $this->render( 'markaxis/employee/log.tpl', $vars );
    }
}
?>