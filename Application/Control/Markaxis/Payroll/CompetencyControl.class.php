<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\CompetencyModel;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CompetencyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyControl {


    // Properties
    private $CompetencyModel;
    private $CompetencyView;


    /**
     * CompetencyControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->CompetencyModel = CompetencyModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'competency' => $this->CompetencyModel->getByUserID( $data['empInfo']['userID'], '*' ) ) );
    }
}
?>