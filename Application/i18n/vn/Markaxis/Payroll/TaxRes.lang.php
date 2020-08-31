<?php
namespace Markaxis\Payroll;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRes extends Resource {


    // Properties


    /**
     * TaxRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_ENTER_RULE_TITLE'] = 'Vui lòng nhập Tiêu đề quy tắc.';
        $this->contents['LANG_INVALID_COUNTRY'] = 'Vui lòng chọn một quốc gia hợp lệ';
        $this->contents['LANG_DEDUCTION_FROM_ORDINARY_WAGE'] = 'Khấu trừ tiền lương bình thường';
        $this->contents['LANG_DEDUCTION_FROM_ADDITIONAL_WAGE'] = 'Khấu trừ tiền lương bổ sung';
        $this->contents['LANG_EMPLOYER_CONTRIBUTION'] = 'Đóng góp của chủ lao động';
        $this->contents['LANG_EMPLOYER_LEVY'] = 'Lệ phí nhà tuyển dụng';
        $this->contents['LANG_CRITERIA'] = 'Tiêu chí';
    }
}
?>