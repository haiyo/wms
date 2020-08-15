<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxFileControl {


    // Properties
    private $TaxFileModel;
    private $TaxFileView;


    /**
     * TaxControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxFileModel = TaxFileModel::getInstance( );
        $this->TaxFileView = new TaxFileView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function taxfile( ) {

        $endpoint = 'https://apisandbox.iras.gov.sg/iras/sb/Authentication/CorpPassAuth?';

        $fields = array(
            'client_id' => urlencode('1425d73f-1459-4dc6-9528-7b2b3b76a249' ),
            'client_secret' => urlencode('H4yH5vG6aW3uN7cM3eT5dX0bT5yV4gO7eL5wC4bD1cB5kX0mU1'),
            'scope' => 'EmpIncomeSub',
            'state' => 'dunno',
            'tax_agent' => 'false'
        );

        $fields_string = "";
        foreach($fields as $key => $value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $endpoint . $fields_string,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array( 'accept: application/json' )
        ));
        $result = curl_exec($ch);
        $result = json_decode( $result );


        var_dump($result); exit;

        $this->TaxFileView->renderTaxFile( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxFiledResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->TaxFileModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function newTaxFiling( ) {
        $this->TaxFileView->renderTaxFileForm( );
    }
}
?>