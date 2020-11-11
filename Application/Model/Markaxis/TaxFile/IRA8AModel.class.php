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
                $this->info['totalBenefits'] = (float)$data['ir8a']['benefitsInKind'];
                $this->IRA8A->update('ira8a', $this->info,
                                     'WHERE userID = "' . (int)$data['ir8a']['userID'] . '" AND 
                                                   tfID = "' . (int)$data['ir8a']['tfID'] . '"' );
                return $iraInfo;
            }
            else {
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

                $this->info['annualValue'] = (float)$post['data']['annualValue'];
                $this->info['furnitureValue'] = (float)$post['data']['furnitureValue'];
                $this->info['rentPaidEmployer'] = (float)$post['data']['rentPaidEmployer'];
                $this->info['rentPaidEmployee'] = (float)$post['data']['rentPaidEmployee'];
                $this->info['utilities'] = (float)$post['data']['utilities'];
                $this->info['driver'] = (float)$post['data']['driver'];
                $this->info['upkeep'] = (float)$post['data']['upkeep'];
                $this->info['hotel'] = (float)$post['data']['hotel'];
                $this->info['hotelPaidEmployee'] = (float)$post['data']['hotelPaidEmployee'];
                $this->info['incidentalBenefits'] = (float)$post['data']['incidentalBenefits'];
                $this->info['interestPayment'] = (float)$post['data']['interestPayment'];
                $this->info['insurance'] = (float)$post['data']['insurance'];
                $this->info['holidays'] = (float)$post['data']['holidays'];
                $this->info['education'] = (float)$post['data']['education'];
                $this->info['recreation'] = (float)$post['data']['recreation'];
                $this->info['assetGain'] = (float)$post['data']['assetGain'];
                $this->info['vehicleGain'] = (float)$post['data']['vehicleGain'];
                $this->info['carBenefits'] = (float)$post['data']['carBenefits'];
                $this->info['otherBenefits'] = (float)$post['data']['otherBenefits'];

                foreach( $this->info as $key => $value ) {
                    if( $value < 1 ) {
                        $this->info[$key] = NULL;
                    }
                }

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

                $periodFrom = new \DateTime( $this->info['periodFrom'] );
                $periodTo = new \DateTime( $this->info['periodTo'] );

                if( $periodTo < $periodFrom ) {
                    $this->setErrMsg('Period To date cannot be earlier than Period From.' );
                    return false;
                }

                if( $this->info['annualValue'] || $this->info['furnitureValue'] ) {
                    $this->info['taxableValue'] = (float)($this->info['annualValue']+$this->info['furnitureValue']);
                }
                else if( $this->info['rentPaidEmployer'] ) {
                    $this->info['taxableValue'] = (float)$this->info['rentPaidEmployer'];
                }


                if( $this->info['taxableValue'] > 0 ) {
                    if( $this->info['rentPaidEmployee'] > 0 && $this->info['taxableValue'] < $this->info['rentPaidEmployee'] ) {
                        $this->setErrMsg('Taxable value should not be less than Rent paid by Employee.' );
                        return false;
                    }
                    $this->info['totalTaxablePlace'] = (float)($this->info['taxableValue']-$this->info['rentPaidEmployee']);
                }

                $totalUtilities = ($this->info['utilities']+$this->info['driver']+$this->info['upkeep']);

                if( $totalUtilities > 0 ) {
                    $this->info['totalTaxableUtilities'] = (float)$totalUtilities;
                }

                $this->info['hotelTotal'] = '';

                if( $this->info['hotel'] > 0 ) {
                    if( $this->info['hotelPaidEmployee'] > 0 ) {
                        $totalHotel = (float)($this->info['hotel']-$this->info['hotelPaidEmployee']);
                        $this->info['hotelTotal'] = $totalHotel < 0 ? 0 : $totalHotel; // if negative default to 0;
                    }
                    else {
                        // Give this a value 0 for iras to compute -.-
                        $this->info['hotelPaidEmployee'] = 0;
                        $this->info['hotelTotal'] = (float)$this->info['hotel'];
                    }
                }

                $totalBenefits = ($this->info['totalTaxablePlace']+$this->info['totalTaxableUtilities']+$this->info['hotelTotal']+
                    $this->info['incidentalBenefits']+$this->info['interestPayment']+$this->info['insurance']+
                    $this->info['holidays']+$this->info['education']+$this->info['recreation']+
                    $this->info['assetGain']+$this->info['vehicleGain']+$this->info['carBenefits']+$this->info['otherBenefits']);

                if( $ira8aInfo['totalBenefits'] != $totalBenefits ) {
                    $this->setErrMsg('Your total benefits value does not compute to the Total Value of Benefits-In-Kind.' );
                    return false;
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