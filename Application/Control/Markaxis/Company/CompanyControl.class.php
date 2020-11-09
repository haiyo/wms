<?php
namespace Markaxis\Company;
use \Markaxis\Employee\EmployeeView;
use \Library\IO\File;
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
    public function logo( $args ) {
        $logoType = isset( $args[1] ) && $args[1] == 'main' ? 'company_uID' : 'slip_uID';
        $filename = $this->CompanyModel->getLogo( $logoType );

        $mimeType = File::getType( $filename );
        $content = file_get_contents( $filename );
        header('Content-Type: ' . $mimeType);
        header('Content-Length: '.strlen( $content ));
        header('Content-disposition: inline; filename="logo');
        header('Cache-Control: public, must-revalidate, max-age=0');
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        echo $content;
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

            if( $this->CompanyModel->save( $post ) ) {
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->IR8AModel->getErrMsg( );
            }
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