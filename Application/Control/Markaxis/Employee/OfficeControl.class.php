<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: OfficeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeControl {


    // Properties
    private $OfficeModel;


    /**
     * OfficeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->OfficeModel = OfficeModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCountList( $data ) {
        if( isset( $data[1] ) && $data[1] == 'office' && isset( $data[2] ) ) {
            Control::setOutputArrayAppend( array( 'list' => $this->OfficeModel->getCountList( $data[2] ) ) );
        }
    }
}
?>