<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EmployeeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeRes extends Resource {


    // Properties


    /**
     * EmployeeRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_EMPLOYEE_DIRECTORY'] = 'Danh bạ nhân viên';
        $this->contents['LANG_ADD_NEW_EMPLOYEE'] = 'Thêm nhân viên mới';
        $this->contents['LANG_EDIT_EMPLOYEE_INFO'] = 'Chỉnh sửa thông tin nhân viên';
        $this->contents['LANG_EDIT_PROFILE'] = 'Chỉnh sửa hồ sơ';
        $this->contents['LANG_EMPLOYEE_TIMESHEET'] = 'Bảng chấm công nhân viên';
        $this->contents['LANG_EMPLOYEE_SETTINGS'] = 'Cài đặt nhân viên';
        $this->contents['LANG_EMPLOYEE'] = 'Nhân viên';
        $this->contents['LANG_EMPLOYEE_ID'] = 'Nhân viên ID';
        $this->contents['LANG_DESIGNATION'] = 'Chỉ định';
        $this->contents['LANG_DEPARTMENT'] = 'Phòng ban';
        $this->contents['LANG_CONTRACT_TYPE'] = 'Thể loại hợp đồng';
        $this->contents['LANG_WORK_PASS'] = 'Work Pass';
        $this->contents['LANG_EMPLOYMENT_START_DATE'] = 'Ngày bắt đầu làm việc';
        $this->contents['LANG_EMPLOYMENT_END_DATE'] = 'Ngày kết thúc việc làm';
        $this->contents['LANG_EMPLOYMENT_CONFIRM_DATE'] = 'Ngày xác nhận việc làm';
        $this->contents['LANG_DIFF_YEAR'] = 'yr';
        $this->contents['LANG_DIFF_MONTH'] = 'mth';
        $this->contents['LANG_DIFF_DAY'] = 'd';
        $this->contents['LANG_COMPETENCY_INFO'] = 'Add multiple competencies for employee eligibility for Courses and/or to
                                                   set criteria for other complicated Tax requirement by the Government
                                                   when you are doing Payroll for this employee. For e.g: NTS and PRC – higher-skilled,
                                                   on MYE.';
    }
}
?>