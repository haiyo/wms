<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ChartControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChartControl {


    // Properties
    protected $ChartModel;


    /**
     * ChartControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ChartModel = ChartModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getChart( ) {
        $vars = array( );
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['date'] ) ) {
            $vars['bool'] = 1;
            Control::setOutputArrayAppend( array( 'data' => $this->ChartModel->getChart( $post['date'] ) ) );
        }
    }
}
?>