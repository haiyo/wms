<?php
namespace Markaxis\Employee;
use \Library\IO\File;
use \Aurora\Component\UploadModel;
use \Library\Util\Date, \Library\Util\Uploader, \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ExperienceModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExperienceModel extends \Model {


    // Properties
    protected $Experience;


    /**
     * ExperienceModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );

        File::import( DAO . 'Markaxis/Employee/Experience.class.php' );
        $this->Experience = new Experience( );

        $this->info['company'] = $this->info['designation'] =  $this->info['description'] =
        $this->info['fromDate'] = $this->info['toDate'] = '';
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $expID ) {
        return $this->Experience->isFoundByUserID( $userID, $expID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUID( $expID, $uID ) {
        return $this->Experience->isFoundByUID( $expID, $uID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->Experience->getByUserID( $userID, $column );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByExpID( $expID, $column ) {
        return $this->Experience->getByExpID( $expID, $column );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        $preg = '/^expCompany_\d{1,}/i';

        $callback = function( $val ) use( $preg ) {
            if( preg_match( $preg, $val, $match ) ) {
                return true;
            } else {
                return false;
            }
        };

        $expCompany = array_filter( $data, $callback, ARRAY_FILTER_USE_KEY );
        $size = sizeof( $expCompany );

        File::import( LIB . 'Util/Date.dll.php' );
        File::import( LIB . 'Validator/Validator.dll.php' );

        for( $i=0; $i<$size; $i++ ) {
            if( !$this->info['company'] = Validator::stripTrim( $data['expCompany_' . $i] ) )
                continue;

            $this->info['designation'] = Validator::stripTrim( $data['expDesignation_' . $i] );
            $this->info['description'] = Validator::stripTrim( $data['expDescription_' . $i] );

            if( !$this->info['fromDate'] = Date::getDateStr( $data['expFromMonth_' . $i], 01, $data['expFromYear_' . $i] ) ) {
                unset( $this->info['fromDate'] );
            }

            if( !$this->info['toDate'] = Date::getDateStr( $data['expToMonth_' . $i], 01, $data['expToYear_' . $i] ) ) {
                unset( $this->info['toDate'] );
            }

            $testimonial = Validator::stripTrim( $data['expTestimonial_' . $i] );
            $hashName = Validator::stripTrim( $data['expHashName_' . $i] );

            if( $testimonial && $hashName ) {
                File::import( MODEL . 'Aurora/Component/UploadModel.class.php' );
                $UploadModel = new UploadModel( );
                if( $UploadModel->isFound( $testimonial, $hashName ) ) {
                    $this->info['uID'] = $testimonial;
                }
            }
            else {
                unset( $this->info['uID'] );
            }

            if( !$data['expID_' . $i] || !$this->isFoundByUserID( $data['userID'], $data['expID_' . $i] ) ) {
                $this->info['userID'] = (int)$data['userID'];
                $this->info['eID'] = (int)$data['eID'];
                $this->Experience->insert( 'employee_experience', $this->info );
            }
            else {
                // Check permission if can update own or somebody else

                $this->Experience->update( 'employee_experience', $this->info,
                                          'WHERE expID = "' . (int)$data['expID_' . $i] . '" AND 
                                                        userID = "' . (int)$data['userID'] . '"' );
            }
        }
    }


    /**
     * Upload file
     * @return bool
     */
    public function deleteExperience( $data ) {
        if( isset( $data['expID'] ) ) {
            if( $expInfo = $this->getByExpID( $data['expID'], '*' ) ) {
                //check if $eduInfo['userID'] == USER || is admin

                $this->Experience->delete( 'employee_experience', 'WHERE expID = "' . (int)$expInfo['expID'] . '"' );

                if( $expInfo['uID'] ) {
                    File::import( MODEL . 'Aurora/Component/UploadModel.class.php' );
                    $UploadModel = new UploadModel( );
                    $fileInfo = $UploadModel->getByUID( $expInfo['uID'] );
                    $UploadModel->deleteFile( $fileInfo['uID'], $fileInfo['hashName'] );
                }
                return true;
            }
        }
        $this->setErrMsg( 'File not found!' );
        return false;
    }


    /**
     * Upload file
     * @return bool
     */
    public function uploadSuccess( $file ) {
        $this->fileInfo['hashDir'] = MD5( date('Y-m-d') );
        $this->fileInfo['dir'] = $this->fileInfo['hashDir'] . '/';

        File::createDir( USER_EXP_DIR . $this->fileInfo['dir'] );

        File::import( LIB . 'Util/Uploader.dll.php' );
        $Uploader = new Uploader( array( 'uploadDir' => USER_EXP_DIR . $this->fileInfo['dir'] ) );

        if( $Uploader->validate( $file['file_data'] ) && $Uploader->upload( ) ) {
            $this->fileInfo = array_merge( $this->fileInfo, $Uploader->getFileInfo( ) );

            File::import( MODEL . 'Aurora/Component/UploadModel.class.php' );
            $UploadModel = new UploadModel( );
            $this->fileInfo['uID'] = $UploadModel->saveUpload( $this->fileInfo );

            if( $this->fileInfo['error'] ) {
                $this->setErrMsg( $this->fileInfo['error'] );
                return false;
            }

            if( $this->fileInfo['success'] == 2 && $this->fileInfo['isImage'] ) {
                $this->processResize( );
            }
            return true;
        }
        return false;
    }


    /**
     * Upload file
     * @return bool
     */
    public function updateTestimonial( $data ) {
        if( isset( $data['expID'] ) && isset( $data['uID'] ) && isset( $data['hashName'] ) ) {
            File::import( MODEL . 'Aurora/Component/UploadModel.class.php' );
            $UploadModel = new UploadModel( );

            if( $UploadModel->isFound( $data['uID'], $data['hashName'] ) ) {
                if( $expInfo = $this->getByExpID( $data['expID'], '*' ) ) {
                    //check if $eduInfo['userID'] == USER || is admin

                    $info = array( );
                    $info['uID'] = (int)$data['uID'];
                    $this->Experience->update( 'employee_experience', $info, 'WHERE expID = "' . (int)$data['expID'] . '"' );
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * Upload file
     * @return bool
     */
    public function deleteTestimonial( $data ) {
        if( isset( $data['expID'] ) && isset( $data['uID'] ) && isset( $data['hashName'] ) ) {
            File::import( MODEL . 'Aurora/Component/UploadModel.class.php' );
            $UploadModel = new UploadModel( );

            if( $this->isFoundByUID( $data['expID'], $data['uID'] ) ) {
                return $UploadModel->deleteFile( $data['uID'], $data['hashName'] );
            }
        }
        $this->setErrMsg( 'File not found!' );
        return false;
    }
}
?>