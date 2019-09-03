<?php
namespace Markaxis\Company;
use \Aurora\Component\UploadModel;
use \Library\IO\File;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: CompanyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyModel extends \Model {


    // Properties
    protected $Company;


    /**
    * CompanyModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Company = new Company( );

        $this->info['company_uID'] = $this->info['slip_uID'] = 0;
        $this->info['regNumber'] = $this->info['name'] =
        $this->info['address'] = $this->info['email'] = $this->info['phone'] =
        $this->info['website'] = $this->info['companyTypeID'] = $this->info['countryID'] = '';
	}


    /**
     * Return total count of records
     * @return int
     */
    public function loadInfo( ) {
        return $this->info = $this->Company->loadInfo( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getLogo( $field ) {
        $UploadModel = new UploadModel( );
        $companyInfo = $this->loadInfo( );

        if( $companyInfo[$field] ) {
            $info = $UploadModel->getByUID( $companyInfo[$field] );
            return ROOT_URL . 'www/mars/logo/' . $info['hashDir'] . $info['hashName'];
        }
        else {
            return ROOT_URL . 'themes/default/assets/images/logo.png';
        }
    }


    /**
    * Save user account information
    * @return int
    */
    public function save( $post ) {
        if( isset( $post['companyLogo'] ) ) {
            $this->saveLogo( $post['companyLogo'], 'company_uID' );
        }
        if( isset( $post['slipLogo'] ) ) {
            $this->saveLogo( $post['slipLogo'], 'slip_uID' );
        }

        if( isset( $post['data']['regNumber'] ) ) {
            $this->info['regNumber'] = Validator::stripTrim( $post['data']['regNumber'] );
            $this->info['name'] = Validator::stripTrim( $post['data']['name'] );
            $this->info['address'] = Validator::stripTrim( $post['data']['address'] );
            $this->info['email'] = Validator::stripTrim( $post['data']['email'] );
            $this->info['phone'] = Validator::stripTrim( $post['data']['phone'] );
            $this->info['website'] = Validator::stripTrim( $post['data']['website'] );
            $this->info['companyTypeID'] = (int)$post['data']['companyType'];
            $this->info['countryID'] = (int)$post['data']['country'];
            $this->Company->update('company', $this->info,'' );
        }
    }


    /**
     * Save user account information
     * @return int
     */
    public function saveLogo( $image, $field ) {
        if( $image ) {
            //$image = urldecode( $image );

            if( preg_match('/^data:image\/(\w+);base64,/', $image, $type ) ) {
                $image = substr( $image, strpos( $image, ',' ) + 1 );
                $type = strtolower( $type[1] ); // jpg, png, gif

                if( in_array( $type, ['jpg', 'jpeg', 'gif', 'png'] ) ) {
                    $image = base64_decode( $image );

                    if( $image ) {
                        $UploadModel = new UploadModel( );

                        $this->fileInfo['hashDir'] = MD5( date('Y-m-d') ) . '/';

                        $salt = MD5( microtime( ) . uniqid( mt_rand( ),true ) );
                        $this->fileInfo['name'] = $salt;
                        $this->fileInfo['hashName'] = "{$salt}.{$type}";
                        $this->fileInfo['size'] = $UploadModel->getBase64Size( $image );
                        $this->fileInfo['created'] = date( 'Y-m-d H:i:s' );

                        File::createDir( LOGO_DIR . $this->fileInfo['hashDir'] );
                        file_put_contents(LOGO_DIR . $this->fileInfo['hashDir'] . $this->fileInfo['hashName'], $image );

                        $this->fileInfo['uID'] = $UploadModel->saveUpload( $this->fileInfo );
                        $this->deleteLogo( $field );

                        $info = array( );
                        $info[$field] = $this->fileInfo['uID'];
                        $this->Company->update('company', $info,'' );
                    }
                }
            }
        }
    }


    /**
     * Save user account information
     * @return int
     */
    public function deleteLogo( $field, $update=false ) {
        $info = $this->loadInfo( );

        $UploadModel = new UploadModel( );
        $UploadModel->deleteFile( $info[$field], LOGO_DIR );

        if( $update ) {
            $info = array( );
            $info[$field] = $this->fileInfo['uID'];
            $this->Company->update('company', $info,'' );
        }
    }
}
?>