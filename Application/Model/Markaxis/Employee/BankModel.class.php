<?php
namespace Markaxis\Employee;
use \Aurora\Component\BankModel as AuroraBankModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: BankModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BankModel extends \Model {


    // Properties
    protected $Bank;



    /**
     * BankModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->info['bkID'] = $this->info['pmID'] = $this->info['bankNumber'] =
        $this->info['bankCode'] = $this->info['branchCode'] = $this->info['bankHolderName'] =
        $this->info['swiftCode'] = $this->info['branchName'] = '';

        $this->Bank = new Bank( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->Bank->isFoundByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->Bank->getByUserID( $userID, $column );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function loadInfo( $userID ) {
        return $this->info = $this->getByUserID( $userID, '*' );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        $saveInfo['pmID'] = (int)$data['pmID'];
        $saveInfo['bankNumber'] = Validator::stripTrim( $data['bankNumber'] );
        $saveInfo['bankCode'] = Validator::stripTrim( $data['bankCode'] );
        $saveInfo['branchCode'] = Validator::stripTrim( $data['branchCode'] );
        $saveInfo['bankHolderName'] = Validator::stripTrim( $data['bankHolderName'] );
        $saveInfo['swiftCode'] = Validator::stripTrim( $data['swiftCode'] );
        $saveInfo['branchName'] = Validator::stripTrim( $data['branchName'] );

        if( isset( $data['paymentMethod'] ) && $data['paymentMethod'] ) {
            $PaymentMethodModel = PaymentMethodModel::getInstance( );

            if( $PaymentMethodModel->isFound( $data['paymentMethod'] ) ) {
                $saveInfo['pmID'] = (int)$data['paymentMethod'];
            }
        }

        if( isset( $data['bank'] ) && $data['bank'] ) {
            $BankModel = AuroraBankModel::getInstance( );

            if( $BankModel->isFound( $data['bank'] ) ) {
                $saveInfo['bkID'] = (int)$data['bank'] ;
            }
        }

        if( $this->isFoundByUserID( $data ) ) {
            $this->Bank->update( 'employee_bank', $saveInfo, 'WHERE userID = "' . (int)$data['userID'] . '"' );
        }
        else {
            $saveInfo['userID'] = (int)$data['userID'];
            $this->Bank->insert('employee_bank', $saveInfo);
        }
    }
}
?>