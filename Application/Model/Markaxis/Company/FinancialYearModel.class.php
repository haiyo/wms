<?php
namespace Markaxis\Company;
use \Markaxis\Employee\EmployeeModel;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: FinancialYearModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FinancialYearModel extends \Model {


    // Properties
    protected $FinancialYear;


    /**
    * FinancialYearModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->FinancialYear = new FinancialYear( );
	}


    /**
    * Return total count of records
    * @return mixed
    */
    public function getRange( ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        $OfficeModel = OfficeModel::getInstance( );
        $fyInfo = $OfficeModel->getByoID( $empInfo['officeID'] );

        if( !$fyInfo['fyStart'] || !$fyInfo['fyEnd'] ) {
            $CompanyModel = CompanyModel::getInstance( );
            $fyInfo = $CompanyModel->getInfo( );
        }
        return array( 'fyStart' => $fyInfo['fyStart'], 'fyEnd' => $fyInfo['fyEnd'] );
    }


    /**
    * Set User Property Info
    * @return bool
    */
    public function isValid( $data ) {
        $Validator = new Validator( );


        return true;
    }


    /**
    * Save user account information
    * @return int
    */
    public function save( ) {
        $userID = $this->info['userID'];
        unset( $this->info['userID'] );

        if( $userID == 0 ) {
            //
        }
        else {
            $this->info['lastUpdate'] = date( 'Y-m-d H:i:s' );
            $this->Company->update( 'user', $this->info, 'WHERE userID="' . (int)$userID . '"' );
            $this->info['userID'] = $userID;

            //
        }
        return $this->info['userID'];
    }
}
?>