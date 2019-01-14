<?php
namespace Markaxis\Employee;
use \Aurora\AuroraView, \Aurora\Component\DesignationModel, \Aurora\Component\ContractModel;
use \Aurora\Component\OfficeModel, \Aurora\Component\CountryModel;
use \Library\IO\File;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveBalanceView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveBalanceView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $LeaveBalanceModel;


    /**
    * TypeView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        File::import( MODEL . 'Markaxis/Employee/LeaveBalanceModel.class.php' );
        $this->LeaveBalanceModel = LeaveBalanceModel::getInstance( );
    }
}
?>