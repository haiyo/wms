<?php
namespace Markaxis\Payroll;
use \Markaxis\Company\CompanyModel;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CPFModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CPFModel extends \Model {


    // Properties
    protected $CPF;
    protected $totalLineRecords; // Include header count first!
    protected $totalAmount = 0;
    protected $newline = "\r\n";


    /**
     * CPFModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->CPF = new CPF( );
    }


    /**
     * Return total count of records
     * @return string
     */
    public function getTotalByDate( $starter, $date, $type, $paymentCode ) {
        $records = $this->CPF->getTotalByDate( $date, $type );

        if( sizeof( $records ) > 0 ) {
            $this->totalAmount += $records['totalAmt'];

            $contribution = str_pad( $this->makeMoneyWorks( $records['totalAmt'] ), 12, 0, STR_PAD_LEFT );
            $count = str_pad( $records['count'], 7, 0,STR_PAD_LEFT );
            $filler = str_pad(' ', 102, ' ' );

            // CPF Summary Record
            return $starter . $paymentCode . $contribution . $count . $filler . $this->newline;
        }
    }


    /**
     * Return total count of records
     * @return string
     */
    public function buildRecordStarter( $recordType, $regNumber, $serialNo, $adviceCode, $yearMonth='' ) {
        return 'F' . $recordType . $regNumber . 'PTE' . $serialNo . ' ' . $adviceCode . $yearMonth;
    }


    /**
     * Return total count of records
     * @return string
     */
    public function buildSelfHelp( $starter, $paymentCode, $nric, $amount, $name ) {
        $ordinary = str_pad( 0,9,0 );
        $additional = str_pad(0,9,0 );
        $filler = str_pad(' ', 57, ' ' );

        $contribution = str_pad( str_replace('.' ,'', $amount ),12,0,STR_PAD_LEFT );

        return $starter . $paymentCode . $nric . $contribution . $ordinary . $additional . ' ' . $name . $filler;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function makeMoneyWorks( $money ) {
        return str_replace('.' ,'', number_format( $money,2, '.', '' ) );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function generateFTPFile( $pID ) {
        $PayrollModel = PayrollModel::getInstance( );

        if( $payrollInfo = $PayrollModel->getBypID( $pID ) ) {
            $processDate = DateTime::createFromFormat('Y-m-d', $payrollInfo['startDate'] );

            $CompanyModel = CompanyModel::getInstance( );
            $regNumber = str_pad( $CompanyModel->getRegNumber( ),10 ,' ',STR_PAD_LEFT );
            $serialNo = '01';
            $adviceCode = '01';

            // Header
            $filler = str_pad(' ', 103, ' ' );
            $data = 'F ' . $regNumber . 'PTE' . $serialNo . ' ' . $adviceCode . $processDate->format('Ymd') . date('His') . 'FTP.DTL' . $filler . $this->newline;
            $this->totalLineRecords++;

            $yearMonth = $processDate->format('Ym');

            // Summary Record
            $starter = $this->buildRecordStarter(0, $regNumber, $serialNo, $adviceCode, $yearMonth );

            $data .= $this->getTotalByDate( $starter, $payrollInfo['startDate'],'CPF','01' );

            $this->totalLineRecords++;

            $data .= $this->getTotalByDate( $starter, $payrollInfo['startDate'],'MBMF','02' );
            $this->totalLineRecords++;

            $data .= $this->getTotalByDate( $starter, $payrollInfo['startDate'],'SINDA','03' );
            $this->totalLineRecords++;

            $data .= $this->getTotalByDate( $starter, $payrollInfo['startDate'],'CDAC','04' );
            $this->totalLineRecords++;

            $data .= $this->getTotalByDate( $starter, $payrollInfo['startDate'],'ECF','05' );
            $this->totalLineRecords++;

            // Detail Record

            $records = $this->CPF->getTaxByUserDate( $payrollInfo['startDate'] );

            if( sizeof( $records ) > 0 ) {
                $starter = $this->buildRecordStarter(1, $regNumber, $serialNo, $adviceCode, $yearMonth );

                $userRow = array( );

                foreach( $records as $rec ) {
                    if( !isset( $userRow[$rec['userID']] ) ) {
                        $userRow[$rec['userID']] = array( );
                        $userRow[$rec['userID']]['data'] = $rec;

                        $userRow[$rec['userID']]['data']['status'] = 'E';

                        // Leaver
                        if( $rec['resigned'] ) {
                            $userRow[$rec['userID']]['data']['status'] = 'L';
                        }

                        // Check if new joiner
                        if( $rec['startDate'] ) {
                            $startMonth = \DateTime::createFromFormat('Y-m-d', $rec['startDate'] )->format('m');
                            $processMonth = $processDate->format('m');

                            if( $startMonth == $processMonth ) {
                                $userRow[$rec['userID']]['data']['status'] = 'N';
                            }

                        }
                    }

                    if( stristr( $rec['title'],'cpf' ) ) {
                        $userRow[$rec['userID']]['ordinary'] = str_pad( $this->makeMoneyWorks( $this->CPF->getGrossBypuID( $rec['puID'] ) ), 10, 0,STR_PAD_LEFT );
                        $userRow[$rec['userID']]['contribution'] = str_pad( $this->makeMoneyWorks( $rec['amount'] ), 12, 0,STR_PAD_LEFT );
                    }

                    if( stristr( $rec['title'],'additional' ) ) {
                        $userRow[$rec['userID']]['additional'] = str_pad( $this->makeMoneyWorks( $rec['amount'] ), 10, 0,STR_PAD_LEFT );
                    }
                }

                if( sizeof( $userRow ) > 0 ) {
                    foreach( $userRow as $row ) {
                        if( !isset( $row['additional'] ) ) {
                            $row['additional'] = str_pad('0', 10, 0 );
                        }

                        $data .= $starter . '01' . $row['data']['nric'] . $row['contribution'] . $row['ordinary'] . $row['additional'] . $row['data']['status'] . $row['data']['name'] . $filler . $this->newline;
                        $this->totalLineRecords++;
                    }
                }

                foreach( $records as $rec ) {
                    if( stristr( $rec['title'],'self-help' ) ) {
                        if( stristr( $rec['title'],'mbmf' ) ) {
                            $data .= $this->buildSelfHelp( $starter, '02', $rec['nric'], $rec['amount'], $rec['name'] ) . $this->newline;
                            $this->totalLineRecords++;
                        }

                        if( stristr( $rec['title'],'sinda' ) ) {
                            $data .= $this->buildSelfHelp( $starter, '03', $rec['nric'], $rec['amount'], $rec['name'] ) . $this->newline;
                            $this->totalLineRecords++;
                        }

                        if( stristr( $rec['title'],'cdac' ) ) {
                            $data .= $this->buildSelfHelp( $starter, '04', $rec['nric'], $rec['amount'], $rec['name'] )  . $this->newline;
                            $this->totalLineRecords++;
                        }

                        if( stristr( $rec['title'],'ecf' ) ) {
                            $data .= $this->buildSelfHelp( $starter, '05', $rec['nric'], $rec['amount'], $rec['name'] ) . $this->newline;
                            $this->totalLineRecords++;
                        }
                    }
                }
            }

            $starter = $this->buildRecordStarter(9, $regNumber, $serialNo, $adviceCode, '' );
            $totalLines = str_pad( $this->totalLineRecords, 7, 0, STR_PAD_LEFT );

            $totalAmount = $this->makeMoneyWorks( $this->totalAmount );
            $totalAmount = str_pad( $totalAmount, 15, 0, STR_PAD_LEFT );

            $data .= $starter . $totalLines . $totalAmount;

            $CompanyModel = CompanyModel::getInstance( );
            $uen = $CompanyModel->getRegNumber( );
            $date = DateTime::createFromFormat('MY', $payrollInfo['startDate'] );;
            $filename = $uen . 'PTE01' . $date . '01.DTL';

            header('Content-Disposition: attachment; filename="' . $filename . '"' );
            header('Content-Type: application/octet-stream' );
            header('Content-Length: ' . strlen( $data ) );
            header('Connection: close' );
            echo $data;
            exit;
        }
    }
}
?>