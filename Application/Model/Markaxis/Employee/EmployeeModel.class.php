<?php
namespace Markaxis\Employee;
use \Library\Helper\Aurora\CurrencyHelper, \Aurora\Component\DesignationModel;
use \Aurora\Component\SalaryTypeModel, \Aurora\Component\OfficeModel, \Aurora\Component\ContractModel;
use \Aurora\Component\PassTypeModel, \Aurora\User\UserModel, \Aurora\Component\AuditLogModel;
use \Library\Util\Date, \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: EmployeeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeModel extends \Model {


    // Properties
    protected $Employee;


    /**
     * EmployeeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );

        $this->info['userID'] = $this->info['salary'] = 0;
        $this->info['idnumber'] = $this->info['currency'] =
        $this->info['passNumber'] = $this->info['confirmDate'] =
        $this->info['startDate'] = $this->info['endDate'] = $this->info['passExpiryDate'] = '';

        $this->Employee = new Employee( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $eID ) {
        return $this->Employee->isFound( $eID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->Employee->isFoundByUserID( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getList( $q='' ) {
        return $this->Employee->getList( $q );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getFieldByUserID( $userID, $column ) {
        return $this->info = $this->Employee->getFieldByUserID( $userID, $column );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Employee->setLimit( $post['start'], $post['length'] );

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

        $results = $this->Employee->getResults( $post['search']['value'], $order . $dir );

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
        $User = new \Aurora\User\User( );

        if( $userInfo = $User->getFieldByUserID( $userID, 'userID, fname, lname' ) ) {
            $this->Employee->setLimit( $post['start'], $post['length'] );

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

            $results = $this->Employee->getLogsByUserID( $post['search']['value'], $userID, $order . $dir );
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
        $saveInfo = array( );
        $saveInfo['idnumber'] = Validator::stripTrim( $data['idnumber'] );
        $saveInfo['passNumber'] = Validator::stripTrim( $data['passNumber'] );
        $saveInfo['salary'] = Validator::stripTrim( $data['salary'] );

        if( isset( CurrencyHelper::getL10nList( )[$data['currency']] ) ) {
            $saveInfo['currency'] = $data['currency'];
        }

        if( isset( $data['salaryType'] ) ) {
            $SalaryTypeModel = SalaryTypeModel::getInstance( );
            if( $SalaryTypeModel->isFound( $data['salaryType'] ) ) {
                $saveInfo['stID'] = (int)$data['salaryType'];
            }
        }

        if( isset( $data['office'] ) ) {
            $OfficeModel = OfficeModel::getInstance( );
            if( $OfficeModel->isFound( $data['office'] ) ) {
                $saveInfo['oID'] = (int)$data['office'];
            }
        }

        if( isset( $data['designation'] ) ) {
            $DesignationModel = DesignationModel::getInstance( );
            if( $DesignationModel->isFound( $data['designation'] ) ) {
                $saveInfo['dID'] = (int)$data['designation'];
            }
        }

        if( isset( $data['contractType'] ) ) {
            $ContractModel = ContractModel::getInstance( );
            if( $ContractModel->isFound( $data['contractType'] ) ) {
                $saveInfo['cID'] = (int)$data['contractType'];
            }
        }

        if( isset( $data['passType'] ) ) {
            $PassTypeModel = PassTypeModel::getInstance( );
            if( $PassTypeModel->isFound( $data['passType'] ) ) {
                $saveInfo['ptID'] = (int)$data['passType'];
            }
        }

        $passExpiryDay   = (int)Validator::stripTrim( $data['passExpiryDay'] );
        $passExpiryMonth = (int)Validator::stripTrim( $data['passExpiryMonth'] );
        $passExpiryYear  = (int)Validator::stripTrim( $data['passExpiryYear'] );

        if( !$saveInfo['passExpiryDate'] = Date::getDateStr( $passExpiryMonth, $passExpiryDay, $passExpiryYear ) ) {
            unset( $saveInfo['passExpiryDate'] );
        }

        $confirmDay   = (int)Validator::stripTrim( $data['confirmDay'] );
        $confirmMonth = (int)Validator::stripTrim( $data['confirmMonth'] );
        $confirmYear  = (int)Validator::stripTrim( $data['confirmYear'] );

        if( !$saveInfo['confirmDate'] = Date::getDateStr( $confirmMonth, $confirmDay, $confirmYear ) ) {
            unset( $saveInfo['confirmDate'] );
        }

        $startDay   = (int)Validator::stripTrim( $data['startDay'] );
        $startMonth = (int)Validator::stripTrim( $data['startMonth'] );
        $startYear  = (int)Validator::stripTrim( $data['startYear'] );

        if( !$saveInfo['startDate'] = Date::getDateStr( $startMonth, $startDay, $startYear ) ) {
            unset( $saveInfo['startDate'] );
        }

        $endDay   = (int)Validator::stripTrim( $data['endDay'] );
        $endMonth = (int)Validator::stripTrim( $data['endMonth'] );
        $endYear  = (int)Validator::stripTrim( $data['endYear'] );

        if( !$saveInfo['endDate'] = Date::getDateStr( $endMonth, $endDay, $endYear ) ) {
            unset( $saveInfo['endDate'] );
        }

        $saveInfo['userID'] = (int)$data['userID'];

        if( $info = $this->getFieldByUserID( $saveInfo['userID'], 'e.eID' ) ) {
            $eID = $info['eID'];
            $this->Employee->update( 'employee', $saveInfo, 'WHERE eID = "' . (int)$eID . '"' );
        }
        else {
            $eID = $this->Employee->insert('employee', $saveInfo);
        }
        return $eID;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function setResignStatus( $post ) {
        $UserModel = new UserModel( );

        if( $UserModel->isFound( $post['userID'] ) ) {
            $info = array( );
            $info['resigned'] = $post['status'] == 1 ? 1 : 0;;
            $this->Employee->update( 'employee', $info, 'WHERE userID = "' . (int)$post['userID'] . '"' );

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