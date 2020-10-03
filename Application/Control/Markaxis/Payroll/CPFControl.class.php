<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CPFControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CPFControl {


    // Properties
    protected $CPFModel;
    protected $CPFView;


    /**
     * CPFControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->CPFModel = CPFModel::getInstance( );
        //$this->CPFView = new CPFView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function downloadCPF( $args ) {
        if( isset( $args[1] ) ) {
            $data = $this->CPFModel->generateFTPFile( $args[1] );

            /*header('Content-Disposition: attachment; filename="' . 'test.txt' . '"' );
            header('Content-Type: application/octet-stream' );
            header('Content-Length: ' . strlen( $data ) );
            header('Connection: close' );
            echo $data;*/
        }
    }
}
?>