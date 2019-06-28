<?php
namespace Markaxis\Employee;
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
        $this->CompetencyView = new CompetencyView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_competency' ) ) {
            Control::setOutputArrayAppend( $this->CompetencyView->renderSettings( ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCompetencyResults( ) {
        $post = Control::getRequest( )->request( POST );

        echo json_encode( $this->CompetencyModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCompetency( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->CompetencyModel->getBycID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCountList( $data ) {
        if( isset( $data[1] ) && $data[1] == 'competency' && isset( $data[2] ) ) {
            Control::setOutputArrayAppend( array( 'list' => $this->CompetencyModel->getCountList( $data[2] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCompetencyToken( $arg ) {
        $userID = isset( $arg[1] ) ? $arg[1] : false;

        $vars = array( );
        $vars['data'] = $this->CompetencyModel->getCompetencyToken( $userID );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->CompetencyModel->isValid( $post ) ) {
            $this->CompetencyModel->save( );
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->CompetencyModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string

    public function saveCompetency( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_competency' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

            if( $this->CompetencyModel->isValid( $post ) ) {
                $this->CompetencyModel->saveCompetency( );
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->CompetencyModel->getErrMsg( );
            }
            echo json_encode( $vars );
            exit;
        }
    } */


    /**
     * Render main navigation
     * @return string
     */
    public function deleteCompetency( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_competency' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

            if( $vars['count'] = $this->CompetencyModel->delete( $post ) ) {
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->CompetencyModel->getErrMsg( );
            }
            echo json_encode( $vars );
            exit;
        }
    }
}
?>