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
        $this->TaxFileView->renderTaxFile( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxFileResults( ) {
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