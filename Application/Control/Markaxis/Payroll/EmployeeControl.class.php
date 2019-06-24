<?php
namespace Markaxis\Payroll;
use \Control;
use \Library\Http\HttpResponse;
use \Library\Exception\Aurora\PageNotFoundException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EmployeeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeControl {


    // Properties
    private $EmployeeModel;
    private $EmployeeView;


    /**
     * EmployeeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->EmployeeModel = EmployeeModel::getInstance( );
        $this->EmployeeView = new EmployeeView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args, $reprocess=false ) {
        try {
            if( isset( $args[1] ) && $empInfo = $this->EmployeeModel->getProcessInfo( $args[1] ) ) {
                Control::setOutputArray( array( 'empInfo' => $empInfo ) );

                if( !$reprocess ) {
                    Control::setOutputArray( $this->EmployeeView->renderProcessForm( $empInfo ) );
                }
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
    public function reprocessPayroll( $args ) {
        $this->processPayroll( $args, true );
    }
}
?>