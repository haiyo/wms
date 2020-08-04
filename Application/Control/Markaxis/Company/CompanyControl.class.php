<?php
namespace Markaxis\Company;
use \Markaxis\Employee\EmployeeView;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CompanyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyControl {


    // Properties
    private $CompanyModel;
    private $CompanyView;


    /**
     * CompanyControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->CompanyModel = CompanyModel::getInstance( );
        $this->CompanyView = new CompanyView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function setup( ) {
        if( Control::hasPermission('Markaxis', 'modify_company_settings' ) ) {
            $this->CompanyView->renderSetup( );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        if( Control::hasPermission('Markaxis', 'modify_company_settings' ) ) {
            $output = Control::getOutputArray( );
            $this->CompanyView->renderSettings( $output );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCountList( ) {
        if( Control::hasPermission('Markaxis', 'modify_company_settings' ) ) {
            $output = Control::getOutputArray( );

            if( isset( $output['list'] ) ) {
                $EmployeeView = new EmployeeView( );
                echo $EmployeeView->renderCountList( $output['list'] );
                exit;
            }
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveCompanySettings( ) {
        if( Control::hasPermission('Markaxis', 'modify_company_settings' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
            $this->CompanyModel->save( $post );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteLogo( ) {
        if( Control::hasPermission('Markaxis', 'modify_company_settings' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

            if( $post['logo'] == 'Company' ) {
                $field = 'company_uID';
            }
            else {
                $field = 'slip_uID';
            }

            $this->CompanyModel->deleteLogo( $field, true );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>