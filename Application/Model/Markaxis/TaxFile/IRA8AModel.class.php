<?php
namespace Markaxis\TaxFile;
use \Aurora\User\UserModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: IRA8AModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IRA8AModel extends \Model {


    // Properties
    protected $IRA8A;



    /**
     * IR8AModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/TaxFile/TaxFileRes');

        $this->IRA8A = new IRA8A( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserIDTFID( $userID, $tfID ) {
        return $this->IRA8A->isFoundByUserIDTFID( $userID, $tfID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByTFID( $tfID ) {
        return $this->IRA8A->getByTFID( $tfID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserIDTFID( $userID, $tfID ) {
        return $this->IRA8A->getByUserIDTFID( $userID, $tfID );
    }


    /**
     * Save Pay Item information
     * @return mixed
     */
    public function prepareUserDeclaration( $data ) {
        if( isset( $data['ir8a']['benefitsInKind'] ) && $data['ir8a']['benefitsInKind'] > 0 ) {
            $UserModel = new UserModel( );
            $userInfo = $UserModel->getFieldByUserID( $data['ir8a']['userID'], 'u.fname, u.lname, u.nric' );

            $this->info = array(
                'tfID' => $data['ir8a']['tfID'],
                'userID' => $data['ir8a']['userID'],
                'empIDNo' => $userInfo['nric'],
                'empName' => $userInfo['fname'] . ' ' . $userInfo['lname'] );

            if( $iraInfo = $this->getByUserIDTFID( $data['ir8a']['userID'], $data['ir8a']['tfID'] ) ) {
                $this->IRA8A->update('ira8a', $this->info,
                                     'WHERE userID = "' . (int)$data['ir8a']['userID'] . '" AND 
                                                   tfID = "' . (int)$data['ir8a']['tfID'] . '"' );
                return $iraInfo;
            }
            else {
                $this->info['totalBenefits'] = (float)$data['ir8a']['benefitsInKind'];
                $this->info['completed'] = 0;
                $this->IRA8A->insert('ira8a', $this->info );
                return $this->info;
            }
        }
        else {
            $TaxFileModel = TaxFileModel::getInstance( );
            $TaxFileModel->setCompleted( $data['ir8a']['tfID'] );
            return false;
        }
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function saveIra8a( $post ) {
        if( isset( $post['data']['tfID'] ) && isset( $post['data']['userID'] ) ) {
            if( $ira8aInfo = $this->getByUserIDTFID( $post['data']['userID'], $post['data']['tfID'] ) ) {
                $this->info = array( );
                $this->info['address'] = Validator::stripTrim( $post['data']['address'] );
                $this->info['days'] = (int)$post['data']['days'];
                $this->info['numberShare'] = (int)$post['data']['numberShare'];

                $this->info['annualValue'] = (int)$post['data']['annualValue'];
                $this->info['furnitureValue'] = (int)$post['data']['furnitureValue'];
                $this->info['rentPaidEmployer'] = (int)$post['data']['rentPaidEmployer'];
                $this->info['taxableValue'] = (int)$post['data']['taxableValue'];
                $this->info['rentPaidEmployee'] = (int)$post['data']['rentPaidEmployee'];
                $this->info['totalTaxablePlace'] = (int)$post['data']['totalTaxablePlace'];
                $this->info['utilities'] = (int)$post['data']['utilities'];
                $this->info['driver'] = (int)$post['data']['driver'];
                $this->info['upkeep'] = (int)$post['data']['upkeep'];
                $this->info['totalTaxableUtilities'] = (int)$post['data']['totalTaxableUtilities'];
                $this->info['hotel'] = (int)$post['data']['hotel'];
                $this->info['hotelPaidEmployee'] = (int)$post['data']['hotelPaidEmployee'];
                $this->info['hotelTotal'] = (int)$post['data']['hotelTotal'];
                $this->info['incidentalBenefits'] = (int)$post['data']['incidentalBenefits'];
                $this->info['interestPayment'] = (int)$post['data']['interestPayment'];
                $this->info['insurance'] = (int)$post['data']['insurance'];
                $this->info['holidays'] = (int)$post['data']['holidays'];
                $this->info['education'] = (int)$post['data']['education'];
                $this->info['recreation'] = (int)$post['data']['recreation'];
                $this->info['assetGain'] = (int)$post['data']['assetGain'];
                $this->info['vehicleGain'] = (int)$post['data']['vehicleGain'];
                $this->info['carBenefits'] = (int)$post['data']['carBenefits'];
                $this->info['otherBenefits'] = (int)$post['data']['otherBenefits'];

                $totalAmt = 0;
                foreach( $this->info as $key => $amt ) {
                    if( $key != 'address' && $key != 'days' && $key != 'numberShare' ) {
                        $totalAmt += $amt;
                    }
                }

                /*if( $ira8aInfo['totalBenefits'] != $totalAmt ) {
                    $this->setErrMsg( 'Amount does not tally with the Total Value of Benefits-In-Kind!' );
                    return false;
                }*/

                if( checkdate( (int)$post['data']['fromMonth'], (int)$post['data']['fromDay'], (int)$post['data']['fromYear'] ) ) {
                    $this->info['periodFrom'] = $post['data']['fromYear'] . '-' .
                                                $post['data']['fromMonth'] . '-' .
                                                $post['data']['fromDay'];
                }

                if( checkdate( (int)$post['data']['toMonth'], (int)$post['data']['toDay'], (int)$post['data']['toYear'] ) ) {
                    $this->info['periodTo'] = $post['data']['toYear'] . '-' .
                                              $post['data']['toMonth'] . '-' .
                                              $post['data']['toDay'];
                }

                $this->info['completed'] = 1;
                $this->IRA8A->update('ira8a', $this->info,
                                    'WHERE tfID = "' . (int)$post['data']['tfID']  . '" AND
                                                              userID = "' . (int)$post['data']['userID'] . '"' );

                $TaxFileModel = TaxFileModel::getInstance( );
                $TaxFileModel->setCompleted( $post['data']['tfID'] );
                return true;
            }
        }
        return false;
    }
}
?>