<?php
namespace Markaxis\Employee;
use \Library\IO\File;
use \Date, \Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TimesheetModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TimesheetModel extends \Model {


    // Properties



    /**
     * TimesheetModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );

        $this->info['userID'] = $this->info['salary'] = 0;
        $this->info['idnumber'] = $this->info['currency'] =
        $this->info['bankNumber'] = $this->info['bankCode'] =
        $this->info['branchCode'] = $this->info['bankHolderName'] = $this->info['swiftCode'] =
        $this->info['branchName'] = $this->info['passNumber'] = $this->info['confirmDate'] =
        $this->info['startDate'] = $this->info['endDate'] = $this->info['passExpiryDate'] = '';
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $eID ) {
        File::import( DAO . 'Markaxis/Employee/Employee.class.php' );
        $Employee = new Employee( );
        return $Employee->isFound( $eID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        File::import( DAO . 'Markaxis/Employee/Employee.class.php' );
        $Employee = new Employee( );
        return $Employee->isFoundByUserID( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getList( ) {
        File::import( DAO . 'Markaxis/Employee/Employee.class.php' );
        $Employee = new Employee( );
        return $Employee->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getFieldByUserID( $userID, $column ) {
        File::import( DAO . 'Markaxis/Employee/Employee.class.php' );
        $Employee = new Employee( );
        return $Employee->getFieldByUserID( $userID, $column );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        File::import( DAO . 'Markaxis/Employee/Employee.class.php' );
        $Employee = new Employee( );
        $Employee->setLimit( $post['start'], $post['length'] );

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'e.idnumber';
                    break;
                case 2:
                    $order = 'name';
                    break;
                case 3:
                    $order = 'd.title';
                    break;
                case 4:
                    $order = 'e.email1';
                    break;
                case 5:
                    $order = 'u.mobile';
                    break;
                case 6:
                    $order = 'u.suspended';
                    break;
            }
        }

        $results = $Employee->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getLogsByUserID( $post, $userID ) {
        File::import( DAO . 'Aurora/User/User.class.php' );
        $User = new User( );

        if( $userInfo = $User->getFieldByUserID( $userID, 'userID, fname, lname' ) ) {
            File::import(DAO . 'Markaxis/Employee/Employee.class.php');
            $Employee = new Employee();
            $Employee->setLimit( $post['start'], $post['length'] );

            $order = 'created';
            $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

            if( isset( $post['order'][0]['column'] ) ) {
                switch( $post['order'][0]['column'] ) {
                    case 0:
                        $order = 'al.eventType';
                        break;
                    case 1:
                        $order = 'al.action';
                        break;
                    case 2:
                        $order = 'al.descript';
                        break;
                    case 3:
                        $order = 'al.created';
                        break;
                }
            }

            $results = $Employee->getLogsByUserID( $post['search']['value'], $userID, $order . $dir );
            $total = $results['recordsTotal'];
            unset( $results['recordsTotal'] );

            return array( 'draw' => (int)$post['draw'],
                          'recordsFiltered' => $total,
                          'recordsTotal' => $total,
                          'data' => $results );
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        File::import( LIB . 'Util/Date.dll.php' );
        File::import( LIB . 'Validator/Validator.dll.php' );

        $this->info['idnumber'] = Validator::stripTrim( $data['idnumber'] );
        $this->info['bankNumber'] = Validator::stripTrim( $data['bankNumber'] );
        $this->info['bankCode'] = Validator::stripTrim( $data['bankCode'] );
        $this->info['branchCode'] = Validator::stripTrim( $data['branchCode'] );
        $this->info['bankHolderName'] = Validator::stripTrim( $data['bankHolderName'] );
        $this->info['swiftCode'] = Validator::stripTrim( $data['swiftCode'] );
        $this->info['branchName'] = Validator::stripTrim( $data['branchName'] );
        $this->info['passNumber'] = Validator::stripTrim( $data['passNumber'] );
        $this->info['salary'] = Validator::stripTrim( $data['salary'] );

        if( isset( CurrencyHelper::getL10nList( )[$data['currency']] ) ) {
            $this->info['currency'] = $data['currency'];
        }

        if( isset( $data['salaryType'] ) ) {
            File::import( MODEL . 'Aurora/Component/SalaryTypeModel.class.php' );
            $SalaryTypeModel = SalaryTypeModel::getInstance( );
            if( $SalaryTypeModel->isFound( $data['salaryType'] ) ) {
                $this->info['stID'] = (int)$data['salaryType'];
            }
        }

        if( isset( $data['office'] ) ) {
            File::import( MODEL . 'Aurora/Component/OfficeModel.class.php' );
            $OfficeModel = OfficeModel::getInstance( );
            if( $OfficeModel->isFound( $data['office'] ) ) {
                $this->info['oID'] = (int)$data['office'];
            }
        }

        if( isset( $data['designation'] ) ) {
            File::import( MODEL . 'Aurora/Component/DesignationModel.class.php' );
            $DesignationModel = DesignationModel::getInstance( );
            if( $DesignationModel->isFound( $data['designation'] ) ) {
                $this->info['dID'] = (int)$data['designation'];
            }
        }

        if( isset( $data['contractType'] ) ) {
            File::import( MODEL . 'Aurora/Component/ContractModel.class.php' );
            $ContractModel = ContractModel::getInstance( );
            if( $ContractModel->isFound( $data['contractType'] ) ) {
                $this->info['cID'] = (int)$data['contractType'];
            }
        }

        if( isset( $data['passType'] ) ) {
            File::import( MODEL . 'Aurora/Component/PassTypeModel.class.php' );
            $PassTypeModel = PassTypeModel::getInstance( );
            if( $PassTypeModel->isFound( $data['passType'] ) ) {
                $this->info['ptID'] = (int)$data['passType'];
            }
        }

        $passExpiryDay   = (int)Validator::stripTrim( $data['passExpiryDay'] );
        $passExpiryMonth = (int)Validator::stripTrim( $data['passExpiryMonth'] );
        $passExpiryYear  = (int)Validator::stripTrim( $data['passExpiryYear'] );

        if( !$this->info['passExpiryDate'] = Date::getDateStr( $passExpiryMonth, $passExpiryDay, $passExpiryYear ) ) {
            unset( $this->info['passExpiryDate'] );
        }

        $confirmDay   = (int)Validator::stripTrim( $data['confirmDay'] );
        $confirmMonth = (int)Validator::stripTrim( $data['confirmMonth'] );
        $confirmYear  = (int)Validator::stripTrim( $data['confirmYear'] );

        if( !$this->info['confirmDate'] = Date::getDateStr( $confirmMonth, $confirmDay, $confirmYear ) ) {
            unset( $this->info['confirmDate'] );
        }

        $startDay   = (int)Validator::stripTrim( $data['startDay'] );
        $startMonth = (int)Validator::stripTrim( $data['startMonth'] );
        $startYear  = (int)Validator::stripTrim( $data['startYear'] );

        if( !$this->info['startDate'] = Date::getDateStr( $startMonth, $startDay, $startYear ) ) {
            unset( $this->info['startDate'] );
        }

        $endDay   = (int)Validator::stripTrim( $data['endDay'] );
        $endMonth = (int)Validator::stripTrim( $data['endMonth'] );
        $endYear  = (int)Validator::stripTrim( $data['endYear'] );

        if( !$this->info['endDate'] = Date::getDateStr( $endMonth, $endDay, $endYear ) ) {
            unset( $this->info['endDate'] );
        }

        if( isset( $data['paymentMethod'] ) ) {
            File::import( MODEL . 'Aurora/Component/PaymentMethodModel.class.php' );
            $PaymentMethodModel = PaymentMethodModel::getInstance( );
            if( $PaymentMethodModel->isFound( $data['paymentMethod'] ) ) {
                $this->info['pmID'] = (int)$data['paymentMethod'];
            }
        }

        if( isset( $data['bank'] ) ) {
            File::import( MODEL . 'Aurora/Component/BankModel.class.php' );
            $BankModel = BankModel::getInstance( );
            if( $BankModel->isFound( $data['bank'] ) ) {
                $this->info['bkID'] = (int)$data['bank'] ;
            }
        }

        File::import( DAO . 'Markaxis/Employee/Employee.class.php' );
        $Employee = new Employee( );
        $this->info['userID'] = (int)$data['userID'];

        if( $info = $this->getFieldByUserID( $this->info['userID'], 'e.eID' ) ) {
            $eID = $info['eID'];
            $Employee->update( 'employee', $this->info, 'WHERE eID = "' . (int)$eID . '"' );
        }
        else {
            $eID = $Employee->insert('employee', $this->info);
        }
        return $eID;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function setResignStatus( $post ) {
        File::import( MODEL . 'Aurora/User/UserModel.class.php' );
        $UserModel = new UserModel( );

        if( $UserModel->isFound( $post['userID'] ) ) {
            File::import( DAO . 'Markaxis/Employee/Employee.class.php' );
            $Employee = new Employee( );

            $info = array( );
            $info['resigned'] = $post['status'] == 1 ? 1 : 0;;
            $Employee->update( 'employee', $info, 'WHERE userID = "' . (int)$post['userID'] . '"' );

            File::import( MODEL . 'Aurora/Component/AuditLogModel.class.php' );
            $AuditLogModel = new AuditLogModel( );

            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            $info['fromUserID'] = $userInfo['userID'];
            $info['toUserID'] = $post['userID'];
            $info['eventType'] = 'employee';
            $info['action'] = $info['resigned'] ? 'resign' : 'reinstate';
            $info['descript'] = addslashes( $post['reason'] );
            $info['created'] = date( 'Y-m-d H:i:s' );
            unset( $info['resigned'] );
            $AuditLogModel->log( $info );
        }
    }
}
?>