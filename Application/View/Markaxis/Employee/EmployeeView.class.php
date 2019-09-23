<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView, \Aurora\Component\DesignationModel, \Aurora\Form\SelectGroupListView;
use \Aurora\Form\DayIntListView, \Aurora\Form\SelectListView;
use \Library\Helper\Aurora\MonthHelper, \Library\Helper\Aurora\CurrencyHelper, \Aurora\Component\SalaryTypeModel;
use \Aurora\Component\OfficeModel, \Aurora\Component\ContractModel, \Aurora\Component\PassTypeModel;
use \Aurora\User\UserRoleModel, \Aurora\User\RoleModel;
use \Aurora\Component\DepartmentModel as A_DepartmentModel;
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
    protected $info;


    /**
    * EmployeeView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/EmployeeRes');

        // Get new instance!
        $this->EmployeeModel = new EmployeeModel( );

        $this->View->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js'),
                                        'plugins/scrollto' => 'jquery.scrollTo.min.js',
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( $data ) {
        if( isset( $data['tab'] ) && isset( $data['form'] ) ) {
            $this->View->setBreadcrumbs( array( 'link' => '',
                                                'icon' => 'icon-cog3',
                                                'text' => $this->L10n->getContents('LANG_EMPLOYEE_SETTINGS') ) );

            $vars = array_merge( $this->L10n->getContents( ),
                    array( 'TPLVAR_HREF' => 'employeeList',
                           'LANG_TEXT' => $this->L10n->getContents( 'LANG_EMPLOYEE' ) ) );

            $vars['TPL_TAB']  = $this->View->render( 'aurora/core/tab.tpl', $vars ) . $data['tab'];
            $vars['TPL_FORM'] = $this->renderList( ) . $data['form'];

            $this->View->printAll( $this->View->render( 'markaxis/employee/settings.tpl', $vars ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderList( ) {
        $this->View->setBreadcrumbs( array( 'link' => 'admin/employee/list',
                                            'icon' => 'icon-users4',
                                            'text' => $this->L10n->getContents('LANG_EMPLOYEE_DIRECTORY') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( 'LANG_LINK' => $this->L10n->getContents('LANG_EMPLOYEE_DIRECTORY') ) );

        $vars['dynamic']['addEmployeeBtn'] = false;

        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
        if( $Authorization->hasPermission( 'Markaxis', 'add_modify_employee' ) ) {
            $vars['dynamic']['addEmployeeBtn'] = true;
        }

        return $this->View->render( 'markaxis/employee/list.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderUserList( ) {
        $this->View->setBreadcrumbs( array( 'link' => 'list',
                                            'icon' => 'icon-users4',
                                            'text' => $this->L10n->getContents('LANG_EMPLOYEE_DIRECTORY') ) );

        $this->View->setJScript( array( 'markaxis' => array( 'user.js' ) ) );

        $DesignationModel = DesignationModel::getInstance( );
        $SelectGroupListView = new SelectGroupListView( );
        $SelectListView = new SelectListView( );

        $designationID = isset( $this->info['designationID'] ) ? $this->info['designationID'] : '';
        $designationList = $SelectGroupListView->build('designation', $DesignationModel->getList( ), $designationID,'Filter By Designation' );

        $DepartmentModel = DepartmentModel::getInstance( );
        $departmentID = isset( $this->info['departmentID'] ) ? $this->info['departmentID'] : '';
        $departmentList = $SelectListView->build( 'department',  $DepartmentModel->getList( ), $departmentID,'Filter By Department' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'LANG_LINK' => $this->L10n->getContents('LANG_EMPLOYEE_DIRECTORY'),
                       'TPL_DEPARTMENT_LIST' => $departmentList,
                       'TPL_DESIGNATION_LIST' => $designationList,
                       'TPL_USER_CARD' => $this->renderUserCard( ) ) );

        $this->View->printAll( $this->View->render( 'markaxis/employee/userList.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderUserCard( $q='', $departmentID='', $designationID='' ) {
        $list = '';

        if( $userList = $this->EmployeeModel->getList( $q, $departmentID, $designationID,true ) ) {
            foreach( $userList as $user ) {
                $list .= $this->View->render( 'markaxis/employee/userCard.tpl',
                                               array( 'TPLVAR_PHOTO' => $user['image'],
                                                      'TPLVAR_NAME' => $user['name'],
                                                      'TPLVAR_DEPARTMENT' => $user['department'],
                                                      'TPLVAR_DESIGNATION' => $user['designation'],
                                                      'TPLVAR_EMAIL' => $user['email'],
                                                      'TPLVAR_MOBILE' => $user['mobile'] ) );
            }
        }
        else {
            $list = $this->View->render( 'markaxis/employee/noUserCard.tpl', array( ) );
        }
        return $list;
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
            return $this->View->render( 'markaxis/employee/countList.tpl', $vars );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderView( ) {
        $vars = array( 'LANG_LINK' => $this->L10n->getContents('LANG_EMPLOYEE_DIRECTORY') );

        return $this->View->render( 'markaxis/employee/view.tpl', $vars );
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
            $confirmDate = explode('-', $this->info['confirmDate'] );
            $confirmDay   = $confirmDate[2];
            $confirmMonth = $confirmDate[1];
            $confirmYear  = $confirmDate[0];
        }
        if( $this->info['startDate'] ) {
            $startDate = explode('-', $this->info['startDate'] );
            $startDay   = $startDate[2];
            $startMonth = $startDate[1];
            $startYear  = $startDate[0];
        }
        if( $this->info['endDate'] ) {
            $endDate = explode('-', $this->info['endDate'] );
            $endDay   = $endDate[2];
            $endMonth = $endDate[1];
            $endYear  = $endDate[0];
        }
        if( $this->info['passExpiryDate'] ) {
            $passExpiry = explode('-', $this->info['passExpiryDate'] );
            $passExpiryDay = $passExpiry[2];
            $passExpiryMonth = $passExpiry[1];
            $passExpiryYear  = $passExpiry[0];
        }
        $DesignationModel = DesignationModel::getInstance( );
        $SelectGroupListView = new SelectGroupListView( );
        $designationID = isset( $this->info['designationID'] ) ? $this->info['designationID'] : '';
        $designationList = $SelectGroupListView->build('designation', $DesignationModel->getList( ), $designationID,'Select Designation' );

        $DepartmentModel = DepartmentModel::getInstance( );
        $departmentID = isset( $this->info['departmentID'] ) ? $this->info['departmentID'] : '';
        $departmentList = $SelectListView->build( 'department',  $DepartmentModel->getList( ), $departmentID,'Select Department(s)' );

        $confirmDayList = $DayIntListView->getList('confirmDay', $confirmDay,'Day' );
        $confirmMonthList = $SelectListView->build('confirmMonth', MonthHelper::getL10nList( ), $confirmMonth, 'Month' );

        $startDayList = $DayIntListView->getList('startDay', $startDay,'Day' );
        $startMonthList = $SelectListView->build('startMonth', MonthHelper::getL10nList( ), $startMonth, 'Month' );

        $endDayList = $DayIntListView->getList('endDay', $endDay,'Day' );
        $endMonthList = $SelectListView->build('endMonth', MonthHelper::getL10nList( ), $endMonth, 'Month' );

        $passExpiryDayList = $DayIntListView->getList('passExpiryDay', $passExpiryDay, 'Day' );
        $passExpiryMonthList = $SelectListView->build('passExpiryMonth', MonthHelper::getL10nList( ), $passExpiryMonth,'Month' );
        $currencyList = $SelectListView->build('currency', CurrencyHelper::getL10nList( ), $this->info['currency'],'Currency' );

        $SalaryTypeModel = SalaryTypeModel::getInstance( );
        $salaryTypeID = isset( $this->info['salaryTypeID'] ) ? $this->info['salaryTypeID'] : '';
        $SelectListView->setClass( 'salaryTypeList' );
        $salaryTypeList = $SelectListView->build('salaryType',  $SalaryTypeModel->getList( ), $salaryTypeID,'Salary Type' );

        $OfficeModel = OfficeModel::getInstance( );

        if( isset( $this->info['officeID'] ) ) {
            $officeID = $this->info['officeID'];
            $officeInfo = $OfficeModel->getByoID( $officeID );
        }
        else {
            $officeID = '';
            $officeInfo = $OfficeModel->getMainOffice( );
        }
        $officeList = $SelectListView->build('office', $OfficeModel->getList( ), $officeID,'Select Office / Location' );

        $ContractModel = ContractModel::getInstance( );
        $contractID = isset( $this->info['contractID'] ) ? $this->info['contractID'] : '';
        $contractList = $SelectListView->build('contractType', $ContractModel->getList( ), $contractID,'Select Contract Type' );

        $PassTypeModel = PassTypeModel::getInstance( );
        $passTypeID = isset( $this->info['passTypeID'] ) ? $this->info['passTypeID'] : '';
        $passTypeList = $SelectGroupListView->build('passType', $PassTypeModel->getList( ), $passTypeID,'Select Pass Type' );

        // === MULTI LIST LEVEL BELOW ===
        $SelectListView->isMultiple(true );
        $SelectListView->includeBlank(false);

        $UserRoleModel = UserRoleModel::getInstance( );
        $RoleModel = RoleModel::getInstance( );
        $selectedRole = $this->info['userID'] ? $UserRoleModel->getByUserID( $this->info['userID'] ) : '';
        $roleList = $SelectListView->build('role', $RoleModel->getList( ), $selectedRole, 'Select Role(s)' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_IDNUMBER' => $this->info['idnumber'],
                       'TPLVAR_CONFIRM_YEAR' => $confirmYear,
                       'TPLVAR_START_YEAR' => $startYear,
                       'TPLVAR_END_YEAR' => $endYear,
                       'TPLVAR_PASS_EXPIRY_YEAR' => $passExpiryYear,
                       'TPLVAR_SALARY' => $officeInfo['currencyCode'] .
                                          $officeInfo['currencySymbol'] .
                                          number_format( $this->info['salary'],2 ),
                       'TPLVAR_PASS_NUMBER' => $this->info['passNumber'],
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

        return $this->View->render( 'markaxis/employee/employeeForm.tpl', $vars );
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


    /**
     * Render main navigation
     * @return string
     */
    public function renderLog( $userID ) {
        $vars = array( 'TPLVAR_USERID' => $userID );
        return $this->View->render( 'markaxis/employee/log.tpl', $vars );
    }
}
?>