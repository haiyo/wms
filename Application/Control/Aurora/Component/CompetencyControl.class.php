<?php
namespace Aurora\Component;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CompetencyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyControl {


    // Properties


    /**
     * CompetencyControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCompetency( $args ) {
        if( isset( $args[1] ) ) {
            $CompetencyModel = CompetencyModel::getInstance( );
            echo json_encode( $CompetencyModel->getResults( $args[1] ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function view( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function add( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $post = Control::getPostData( );

        if( isset( $post['competency'] ) ) {
            $CompetencyModel = CompetencyModel::getInstance( );
            $post['competency'] = $CompetencyModel->save( $post['competency'] );
            Control::setPostData( $post );
        }
    }
}
?>