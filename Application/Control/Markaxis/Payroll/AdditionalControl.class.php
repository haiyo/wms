<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: AdditionalControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdditionalControl {


    // Properties
    protected $AdditionalModel;


    /**
     * AdditionalControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->AdditionalModel = AdditionalModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAdditional( $args ) {
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            Control::setOutputArray( $this->AdditionalModel->getAdditional( $args[1], $args[2] ) );
        }
    }
}
?>