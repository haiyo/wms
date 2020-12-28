<?php
namespace Markaxis\Payroll;

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
            $this->CPFModel->generateFTPFile( $args[1] );
        }
    }
}
?>