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

        $this->info['empAddress'] = $this->info['days'] = $this->info['numberShare'] =
        $this->info['annualValue'] = $this->info['furnitureValue'] = $this->info['rentPaidEmployer'] =
        $this->info['taxableValue'] = $this->info['rentPaidEmployee'] = $this->info['totalTaxablePlace'] =
        $this->info['utilities'] = $this->info['driver'] = $this->info['upkeep'] =
        $this->info['totalTaxableUtilities'] = $this->info['hotel'] = $this->info['hotelPaidEmployee'] = $this->info['hotelTotal'] =
        $this->info['incidentalBenefits'] = $this->info['interestPayment'] = $this->info['insurance'] =
        $this->info['holidays'] = $this->info['education'] = $this->info['recreation'] = $this->info['assetGain'] =
        $this->info['vehicleGain'] = $this->info['carBenefits'] = $this->info['otherBenefits'] = $this->info['totalBenefits'] = '';
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
     * @return mixed
     */
    public function getByUserIDTFID( $userID, $tfID, $returnBlank=false ) {
        $info = $this->IRA8A->getByUserIDTFID( $userID, $tfID );

        // For form filling
        if( !$info && $returnBlank ) {
            return $this->info;
        }
        return $info;
    }


    /**
     * Save Pay Item information
     * @return mixed
     */
    public function prepareUserDeclaration( $data ) {
        if( isset( $data['ir8a']['benefitsInKind'] ) && $data['ir8a']['benefitsInKind'] > 0 &&
            isset( $data['empIR8AInfo']['name'] ) && isset( $data['empIR8AInfo']['nric'] ) ) {

            $this->info = array(
                'tfID' => $data['ir8a']['tfID'],
                'userID' => $data['ir8a']['userID'],
                'empIDNo' => $data['empIR8AInfo']['nric'],
                'empName' => $data['empIR8AInfo']['name'],
                'totalBenefits' => (float)$data['ir8a']['benefitsInKind'] );

            if( $iraInfo = $this->getByUserIDTFID( $data['ir8a']['userID'], $data['ir8a']['tfID'] ) ) {
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

                $check = array( );
                $check['annualValue'] = (float)$post['data']['annualValue'];
                $check['furnitureValue'] = (float)$post['data']['furnitureValue'];
                $check['rentPaidEmployer'] = (float)$post['data']['rentPaidEmployer'];
                $check['rentPaidEmployee'] = (float)$post['data']['rentPaidEmployee'];
                $check['utilities'] = (float)$post['data']['utilities'];
                $check['driver'] = (float)$post['data']['driver'];
                $check['upkeep'] = (float)$post['data']['upkeep'];
                $check['hotel'] = (float)$post['data']['hotel'];
                $check['hotelPaidEmployee'] = (float)$post['data']['hotelPaidEmployee'];
                $check['incidentalBenefits'] = (float)$post['data']['incidentalBenefits'];
                $check['interestPayment'] = (float)$post['data']['interestPayment'];
                $check['insurance'] = (float)$post['data']['insurance'];
                $check['holidays'] = (float)$post['data']['holidays'];
                $check['education'] = (float)$post['data']['education'];
                $check['recreation'] = (float)$post['data']['recreation'];
                $check['assetGain'] = (float)$post['data']['assetGain'];
                $check['vehicleGain'] = (float)$post['data']['vehicleGain'];
                $check['carBenefits'] = (float)$post['data']['carBenefits'];
                $check['otherBenefits'] = (float)$post['data']['otherBenefits'];

                foreach( $check as $key => $value ) {
                    if( $value < 1 ) {
                        $this->info[$key] = NULL;
                    }
                    else {
                        $this->info[$key] = $value;
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

                $totalBenefits = 0;

                if( $this->info['totalTaxablePlace'] > 0 ) {
                    $totalBenefits += $this->info['totalTaxablePlace'];
                }

                if( $this->info['totalTaxableUtilities'] > 0 ) {
                    $totalBenefits += $this->info['totalTaxableUtilities'];
                }

                if( $this->info['hotelTotal'] > 0 ) {
                    $totalBenefits += $this->info['hotelTotal'];
                }

                if( $this->info['incidentalBenefits'] > 0 ) {
                    $totalBenefits += $this->info['incidentalBenefits'];
                }

                if( $this->info['interestPayment'] > 0 ) {
                    $totalBenefits += $this->info['interestPayment'];
                }

                if( $this->info['insurance'] > 0 ) {
                    $totalBenefits += $this->info['insurance'];
                }

                if( $this->info['holidays'] > 0 ) {
                    $totalBenefits += $this->info['holidays'];
                }

                if( $this->info['education'] > 0 ) {
                    $totalBenefits += $this->info['education'];
                }

                if( $this->info['recreation'] > 0 ) {
                    $totalBenefits += $this->info['recreation'];
                }

                if( $this->info['assetGain'] > 0 ) {
                    $totalBenefits += $this->info['assetGain'];
                }

                if( $this->info['vehicleGain'] > 0 ) {
                    $totalBenefits += $this->info['vehicleGain'];
                }

                if( $this->info['carBenefits'] > 0 ) {
                    $totalBenefits += $this->info['carBenefits'];
                }

                if( $this->info['otherBenefits'] > 0 ) {
                    $totalBenefits += $this->info['otherBenefits'];
                }

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