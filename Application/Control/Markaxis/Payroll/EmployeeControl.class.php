<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\EmployeeModel;
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
    private $EmployeeView;


    /**
     * EmployeeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->EmployeeView = new EmployeeView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        try {
            $EmployeeModel = EmployeeModel::getInstance( );

            if( isset( $args[1] ) && $empInfo = $EmployeeModel->getFieldByUserID( $args[1], '*' ) ) {
                Control::setOutputArray( array( 'empInfo' => $empInfo ) );
                Control::setOutputArray( $this->EmployeeView->renderProcessForm( $args[1] ) );
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
}
?>