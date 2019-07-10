<?php
namespace Markaxis\Payroll;
use \Library\Security\Aurora\LockMethod;
use \Library\Validator\Validator;
use \Library\Exception\Aurora\AuthLoginException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollModel extends \Model {


    // Properties
    protected $Payroll;
    private $totalOrdinary;



    /**
     * PayrollModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Payroll = new Payroll( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $prID ) {
        return $this->Payroll->isFound( $prID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByRange( $startDate, $endDate, $userID=false ) {
        return $this->Payroll->getByRange( $startDate, $endDate, $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getCalculateUserInfo( $userID ) {
        return $this->Payroll->getCalculateUserInfo( $userID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function calculateCurrYearOrdinary( $userID, $cappedLimit=false ) {
        if( $this->totalOrdinary ) {
            return $this->totalOrdinary;
        }
        $year = date('Y');
        $startDate = date('Y-m-d', mktime(0, 0, 0, 1, 1, $year) );
        $endDate = date('Y-m-d', mktime(0, 0, 0, 12, 31, $year) );

        $range = $this->Payroll->getByRange( $startDate, $endDate, $userID );
        $this->totalOrdinary = array( 'months' => sizeof( $range ), 'amount' => 0 );

        foreach( $range as $payroll ) {
            if( $cappedLimit && $payroll['ordinary'] > $cappedLimit ) {
                $this->totalOrdinary['amount'] += $cappedLimit;
            }
            else {
                $this->totalOrdinary['amount'] += $payroll['ordinary'];
            }
        }
        return $this->totalOrdinary;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function allowProcessPass( $data ) {
        if( isset( $data['password'] ) && isset( $data['processDate'] ) ) {
            try {
                $pass = Validator::stripTrim( $data['password'] );
                $date = \DateTime::createFromFormat('Y-m-d', $data['processDate'] );

                if( $pass ) {
                    if( $date ) {
                        $method = 'payroll_process_' . $date->format('Y-m-d');

                        $LockMethod = new LockMethod( );
                        if( $LockMethod->verify( $pass ) ) {
                            if( $LockMethod->allow( $method ) ) {
                                $LockMethod->logEntry( $method );
                                return true;
                            }
                        }
                    }
                }
                else {
                    $this->errMsg = $this->L10n->getContents( 'LANG_ENTER_PASSWORD' );
                }
            }
            catch( AuthLoginException $e ) {
                $this->errMsg = $this->L10n->getContents( 'LANG_VERIFICATION_FAILED' );
            }
        }
        $this->errMsg = $this->L10n->getContents( 'LANG_VERIFICATION_FAILED' );
        return false;
    }
}
?>