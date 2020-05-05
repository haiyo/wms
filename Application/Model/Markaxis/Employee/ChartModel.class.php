<?php
namespace Markaxis\Employee;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ChartModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChartModel extends \Model {


    // Properties
    protected $Chart;


    /**
     * ChartModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Chart = new Chart( );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getChart( $date ) {
        return array( 'employees' => $this->Chart->getChart( $date ) );
    }
}
?>