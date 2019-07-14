<?php
namespace Markaxis\Employee;
use \Aurora\Component\CountryModel, \Aurora\Component\UploadModel;
use \Library\IO\File;
use \Library\Util\Date, \Library\Util\Uploader, \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: EducationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EducationModel extends \Model {


    // Properties
    const USER_EDU_DIR = USER_DIR . 'edu/';
    protected $Education;


    /**
     * EducationModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $this->Education = new Education( );

        $this->info['school'] = $this->info['country'] =  $this->info['level'] =
        $this->info['fromDate'] = $this->info['toDate'] = $this->info['specialization'] = '';
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $eduID ) {
        return $this->Education->isFoundByUserID( $userID, $eduID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUID( $eduID, $uID ) {
        return $this->Education->isFoundByUID( $eduID, $uID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->Education->getByUserID( $userID, $column );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByEduID( $eduID, $column ) {
        return $this->Education->getByEduID( $eduID, $column );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        $preg = '/^eduSchool_\d{1,}/i';

        $callback = function( $val ) use( $preg ) {
            if( preg_match( $preg, $val, $match ) ) {
                return true;
            } else {
                return false;
            }
        };

        $eduSchool = array_filter( $data, $callback, ARRAY_FILTER_USE_KEY );
        $size = sizeof( $eduSchool );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );

        for( $i=0; $i<$size; $i++ ) {
            if( !$this->info['school'] = Validator::stripTrim( $data['eduSchool_' . $i] ) )
                continue;

            if( in_array( $data['eduCountry_' . $i], $countries ) ) {
                $this->info['country'] = $data['eduCountry_' . $i];
            }

            $this->info['level'] = Validator::stripTrim( $data['eduLevel_' . $i] );
            $this->info['specialization'] = Validator::stripTrim( $data['eduSpecialize_' . $i] );

            if( !$this->info['fromDate'] = Date::getDateStr( $data['eduFromMonth_' . $i], 01, $data['eduFromYear_' . $i] ) ) {
                unset( $this->info['fromDate'] );
            }

            if( !$this->info['toDate'] = Date::getDateStr( $data['eduToMonth_' . $i], 01, $data['eduToYear_' . $i] ) ) {
                unset( $this->info['toDate'] );
            }

            $certificate = Validator::stripTrim( $data['eduCertificate_' . $i] );
            $hashName = Validator::stripTrim( $data['eduHashName_' . $i] );

            if( $certificate && $hashName ) {
                $UploadModel = new UploadModel( );
                if( $UploadModel->isFound( $certificate, $hashName ) ) {
                    $this->info['uID'] = $certificate;
                }
            }
            else {
                unset( $this->info['uID'] );
            }

            if( !$data['eduID_' . $i] || !$this->isFoundByUserID( $data['userID'], $data['eduID_' . $i] ) ) {
                $this->info['userID'] = (int)$data['userID'];
                $this->info['eID'] = (int)$data['eID'];
                $this->Education->insert( 'employee_education', $this->info );
            }
            else {
                // Check permission if can update own or somebody else

                $this->Education->update( 'employee_education', $this->info,
                                         'WHERE eduID = "' . (int)$data['eduID_' . $i] . '" AND 
                                                       userID = "' . (int)$data['userID'] . '"' );
            }
        }
    }


    /**
     * Upload file
     * @return bool
     */
    public function deleteEducation( $data ) {
        if( isset( $data['eduID'] ) ) {
            if( $eduInfo = $this->getByEduID( $data['eduID'], '*' ) ) {
                //check if $eduInfo['userID'] == USER || is admin

                $this->Education->delete( 'employee_education', 'WHERE eduID = "' . (int)$eduInfo['eduID'] . '"' );

                if( $eduInfo['uID'] ) {
                    $UploadModel = new UploadModel( );
                    $fileInfo = $UploadModel->getByUID( $eduInfo['uID'] );
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

        File::createDir( self::USER_EDU_DIR . $this->fileInfo['dir'] );

        $Uploader = new Uploader( array( 'uploadDir' => self::USER_EDU_DIR . $this->fileInfo['dir'] ) );

        if( $Uploader->validate( $file['file_data'] ) && $Uploader->upload( ) ) {
            $this->fileInfo = array_merge( $this->fileInfo, $Uploader->getFileInfo( ) );

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
    public function updateCertificate( $data ) {
        if( isset( $data['eduID'] ) && isset( $data['uID'] ) && isset( $data['hashName'] ) ) {
            $UploadModel = new UploadModel( );

            if( $UploadModel->isFound( $data['uID'], $data['hashName'] ) ) {
                if( $eduInfo = $this->getByEduID( $data['eduID'], '*' ) ) {
                    //check if $eduInfo['userID'] == USER || is admin

                    $info = array( );
                    $info['uID'] = (int)$data['uID'];
                    $this->Education->update( 'employee_education', $info, 'WHERE eduID = "' . (int)$data['eduID'] . '"' );
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
    public function deleteCertificate( $data ) {
        if( isset( $data['eduID'] ) && isset( $data['uID'] ) && isset( $data['hashName'] ) ) {
            if( $this->isFoundByUID( $data['eduID'], $data['uID'] ) ) {
                $UploadModel = new UploadModel( );
                return $UploadModel->deleteFile( $data['uID'], $data['hashName'] );
            }
        }
        $this->setErrMsg( 'File not found!' );
        return false;
    }
}
?>