<?php
namespace Aurora\Component;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: StateControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StateControl {


    // Properties


    /**
     * StateControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function stateList( ) {
        $post = Control::getRequest( )->request( POST );

        $StateModel = StateModel::getInstance( );
        echo json_encode( $StateModel->getList( $post ) );
        exit;
    }
}
?>