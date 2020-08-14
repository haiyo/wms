<?php
namespace Markaxis\Company;
use \Control;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LOAControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LOAControl {


    // Properties
    private $LOAModel;
    private $LOAView;


    /**
     * LOAControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->LOAModel = LOAModel::getInstance( );
        $this->LOAView = new LOAView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArrayAppend( $this->LOAView->renderNewsAnnouncement( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_loa' ) ) {
            Control::setOutputArrayAppend( $this->LOAView->renderSettings( ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function loa( ) {
        $this->LOAView->renderLOA( );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getContent( $data ) {
        $vars = array( );
        $loaID = isset( $data[1] ) ? $data[1] : $data;

        if( $loaID && $info = $this->LOAModel->getByLoaID( $loaID ) ) {
            $vars['data'] = $info;
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 1;
            $vars['errMsg'] = $this->LOAModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return void
     */
    public function results( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_loa' ) ) {
            $post = Control::getRequest( )->request( POST );
            echo json_encode( $this->LOAModel->getResults( $post ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_loa' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

            if( $this->LOAModel->isValid( $post ) ) {
                $this->LOAModel->save( );
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->LOAModel->getErrMsg( );
            }
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function delete( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_loa' ) ) {
            $loaID = Control::getRequest( )->request( POST, 'data' );

            $this->LOAModel->delete( $loaID );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>