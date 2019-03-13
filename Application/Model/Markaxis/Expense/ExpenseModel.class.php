<?php
namespace Markaxis\Expense;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ExpenseModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseModel extends \Model {


    // Properties
    protected $Expense;



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
    public function getByRange( $startDate, $endDate ) {
        return $this->Payroll->getByRange( $startDate, $endDate );
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