<?php
namespace Markaxis\Payroll;
use \Control;
use \Library\Http\HttpResponse;
use \Library\Exception\Aurora\PageNotFoundException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollControl {


    // Properties
    protected $PayrollModel;
    protected $PayrollView;


    /**
     * PayrollControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollModel = PayrollModel::getInstance( );
        $this->PayrollView = new PayrollView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function overview( ) {
        $this->PayrollView->renderOverview( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function employee( $args ) {
        // pID && officeID
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            $post = Control::getRequest( )->request( POST );
            echo json_encode( $this->PayrollModel->getResults( $post, $args[1], $args[2] ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPayrollEvents( ) {
        $post = Control::getRequest( )->request( POST );

        $vars = array( );
        $vars['events'] = $this->PayrollModel->getEventsBetween( $post );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getProcessPass( ) {
        $vars = array( );
        $post = Control::getRequest( )->request( POST );

        if( $this->PayrollModel->allowProcessPass( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->PayrollModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function setCompleted( ) {
        $post = Control::getRequest( )->request( POST );

        $vars = array( );
        $vars['bool'] = 0;

        if( $this->PayrollModel->setCompleted( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function process( $args ) {
        if( isset( $args[1] ) ) {
            $this->PayrollView->renderProcess( $args[1] );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        try {
            if( isset( $args[2] ) && $payrollInfo = $this->PayrollModel->getBypID( $args[2] ) ) {
                Control::setOutputArray( array( 'payrollInfo' => $payrollInfo ) );
            }
            else {
                throw( new PageNotFoundException( HttpResponse::HTTP_NOT_FOUND ) );
            }
        }
        catch( PageNotFoundException $e ) {
            $e->record( );
            HttpResponse::sendHeader( HttpResponse::HTTP_NOT_FOUND );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function recalculate( $args ) {
        $this->processPayroll( $args );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( $args ) {
        $this->processPayroll( $args );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $post = Control::getRequest( )->request( POST, 'data' );

        if( isset( $post['pID'] ) ) {
            $this->processPayroll( array( 2 => $post['pID'] ),true );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSlip( $args ) {
        $this->processPayroll( $args );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( $args ) {
        $this->processPayroll( $args );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function payment( $args ) {
        if( isset( $_GET['code'] ) ) {

            $fields = array(
                'code' => urlencode( $_GET['code'] ),
                'client_id' => urlencode('6d5acb58-5d68-4309-bc57-8486089dcbc5'),
                'client_secret' => urlencode('9be6702d-95f9-4be1-b8d5-43f820b0b91e'),
                'grant_type' => 'token',
                'redirect_uri' => 'http%3A%2F%2Flocalhost%2Fwms%2Fadmin%2Fpayroll%2Fpayment%2F'
            );

            $fields_string = "";
            foreach($fields as $key => $value) {
                $fields_string .= $key.'='.$value.'&';
            }
            $fields_string = rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://www.dbs.com/sandbox/api/sg/v1/oauth/tokens',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HEADER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HTTPHEADER => array('authorization: Basic ' . base64_encode('6d5acb58-5d68-4309-bc57-8486089dcbc5:9be6702d-95f9-4be1-b8d5-43f820b0b91e'),
                                            'Content-Type: application/x-www-form-urlencoded'),
                CURLOPT_POSTFIELDS => $fields_string,
            ));
            $result = curl_exec($ch);
            $result = json_decode( $result );

            //$result = json_decode($this->refresh( $result ) );

            //echo '<pre>' . var_dump($result) . '</pre>';


            $fields = array(
                'partyId' => urlencode( $result->party_id ),
                'client_id' => urlencode('6d5acb58-5d68-4309-bc57-8486089dcbc5'),
                'client_secret' => urlencode('9be6702d-95f9-4be1-b8d5-43f820b0b91e'),
                'grant_type' => 'token',
                'redirect_uri' => 'http%3A%2F%2Flocalhost%2Fwms%2Fadmin%2Fpayroll%2Fpayment%2F'
            );

            $fields_string = "";
            foreach($fields as $key => $value) {
                $fields_string .= $key.'='.$value.'&';
            }
            $fields_string = rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://www.dbs.com/sandbox/api/sg/v1/payees/payeeCreation',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HEADER => 1,
                CURLOPT_POST => 1,
                CURLOPT_HTTPHEADER => array('Content-Type: application/json',
                                            'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
                                            'clientId:' . '6d5acb58-5d68-4309-bc57-8486089dcbc5',
                                            'accessToken:' . $result->access_token ) ,
                //CURLOPT_POSTFIELDS => '{"payee":{"partyId":"1058634943","partyInitials":"MR","payeeDetail":{"transferPayee":{"payeeName":"Robin","payeeNickname":"Gupta","paymentChannel":"RTGS","bankId":"XYZ","payeeAccount":{"accountNumber":"20010054460009"},"alternatePayeeReference":{"alternateReferenceType":"Treasures","alternateReferenceDesc":"tranferpayee","alternateReference":"accountNumber"},"payeeContacts":{"phone":{"phoneType":"home","phoneNumber":"9972427518"},"email":{"emailAddressType":"home","emailAddress":"asdfg@gmail.com"}}}}}}'
            ));
            //$result = curl_exec($ch);
            //var_dump( $result );
            //exit;


            /*$ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://www.dbs.com/developers/api/sg/v1/directDebits/0010000195/setupStatus/',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HEADER => 1,
                //CURLOPT_POST => 1,
                CURLOPT_HTTPHEADER => array('Content-Type: application/json',
                    'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
                    'clientId:' . '6d5acb58-5d68-4309-bc57-8486089dcbc5',
                    'accessToken:' . $result->access_token ) ,
                //CURLOPT_POSTFIELDS => '{"setupInstruction":{"debitAccount":"03010011230017","billerId":"7171","billingReference":"0012200195","effectiveDate":"2027-10-30","expiryDate":"2032-10-30","maximumPaymentAmount":599.99}}',
            ));
            $result = curl_exec($ch);
            var_dump( $result );
            exit;*/


            //curl -X POST https://www.dbs.com/sandbox/api/sg/v1/directDebits/instructionSetup
            // --header "Content-Type:application/json"
            // --header "clientId:clientId2"
            // --header "accessToken :eyJhbGciOiJIUzI1NiJ9.eyJpc3MiIDogImh0dHBzOi8vY2FwaS5kYnMuY29tIiwiaWF0IiA6IDE1NjgwMT
            //                          gwODQxODcsICJleHAiIDogMTU2ODAyMTY4NDE4Nywic3ViIiA6ICJTVmN3TXpZPSIsInB0eXR5cGUiIDogMSwiY2xuaW
            //                          QiIDogImNsaWVudElkMiIsImNsbnR5cGUiIDogIjIiLCAiYWNjZXNzIiA6ICIxRkEiLCJzY29wZSIgOiAiMkZBLVNNUyIgLCJhdWQiI
            //                          DogImh0dHBzOi8vY2FwaS5kYnMuY29tL2FjY2VzcyIgLCJqdGkiIDogIjM3MDg0NDYxNDgyMjc1NDk1MzUiICwiY2luIiA6ICJRMGxPTURBd01EQXg
            //                          ifQ.pkjIA9tOYMxhN5XsKvkFIxic4avqBUDdaP6Kc7NPtDA"

            // -d '{"setupInstruction":{"debitAccount":"03010011230017","billerId":"7171","billingReference":"0010000195",
            //                          "effectiveDate":"2027-10-30","expiryDate":"2032-10-30","maximumPaymentAmount":9999.99}}
        }
        //http://localhost/wms/admin/payroll/process/2018-12-01
    }


    public function refresh( $result ) {
        // Extra:
        // Before your access token expires, you can refresh it with the `refresh_token`. If it has expired,
        // you will have to re-do the auhorization workflow
        $fields = array(
            'grant_type' => 'refresh_token',
            'client_id' => urlencode('6d5acb58-5d68-4309-bc57-8486089dcbc5'),
            'client_secret' => urlencode('9be6702d-95f9-4be1-b8d5-43f820b0b91e'),
            'refresh_token' => urlencode($result->refresh_token)
        );
        $fields_string = "";
        foreach($fields as $key => $value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://www.dbs.com/sandbox/api/sg/v1/access/refresh',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => array('clientId' => urlencode('6d5acb58-5d68-4309-bc57-8486089dcbc5'),
                                        'authorization: Basic ' . base64_encode('6d5acb58-5d68-4309-bc57-8486089dcbc5:9be6702d-95f9-4be1-b8d5-43f820b0b91e'),
                                        'Content-Type: application/x-www-form-urlencoded'),
            CURLOPT_POSTFIELDS => $fields_string,
        ));
        return curl_exec($ch);
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $output = Control::getOutputArray( );
        $this->PayrollView->renderSettings( $output['form'] );
    }
}
?>