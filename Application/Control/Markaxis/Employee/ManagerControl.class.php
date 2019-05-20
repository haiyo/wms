<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ManagerControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagerControl {


    // Properties
    private $ManagerModel;


    /**
     * ManagerControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ManagerModel = ManagerModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getSuggestToken( $arg ) {
        $userID = isset( $arg[1] ) ? $arg[1] : false;

        $vars = array( );
        $vars['data'] = $this->ManagerModel->getSuggestToken( $userID );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $post = Control::getPostData( );

        $ManagerModel = ManagerModel::getInstance( );
        if( $ManagerModel->isValid( $post ) ) {
            $ManagerModel->save( );
        }
    }
}
?>
