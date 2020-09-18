<?php
namespace Aurora\Support;
use \Aurora\Component\UploadModel;
use \Library\Util\Uploader, \Library\Util\MimeMail;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: SupportModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SupportModel extends \Model {


    // Properties



    /**
     * LeaveApplyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $post ) {
        $Validator = new Validator( );

        $this->info['supportSubject']  = Validator::stripTrim( $post['data']['supportSubject'] );
        $this->info['supportDescript'] = Validator::stripTrim( $post['data']['supportDescript'] );

        $Validator->addModule( 'supportSubject', new IsEmpty( $this->info['supportSubject'] ) );
        $Validator->addModule( 'supportDescript', new IsEmpty( $this->info['supportDescript'] ) );

        try {
            $Validator->validate( );

            if( isset( $post['uID'] ) ) {
                $UploadModel = new UploadModel( );
                $this->info['fileInfo'] = $UploadModel->getByUID( $post['uID'] );
            }
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }
        return true;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function send( ) {
        $MimeMail = new MimeMail('andy@markaxis.com','noreply@hrmscloud.net', $this->info['supportSubject'], $this->info['supportDescript'] );

        if( isset( $this->info['fileInfo'] ) ) {
            $MimeMail->attach( array( BACKUP_DIR . $this->info['fileInfo']['hashDir'] . '/' . $this->info['fileInfo']['hashName'] ) );
        }
        $MimeMail->sendmail( );
    }


    /**
     * Upload file
     * @return bool
     */
    public function uploadSuccess( $file ) {
        $Uploader = new Uploader([
            'uploadDir' => BACKUP_DIR
        ]);

        if( $Uploader->validate( $file['file_data'] ) && $Uploader->upload( ) ) {
            $this->fileInfo = $Uploader->getFileInfo( );

            $UploadModel = new UploadModel( );
            $this->fileInfo['uID'] = $UploadModel->saveUpload( $this->fileInfo );

            if( $this->fileInfo['error'] ) {
                $this->setErrMsg( $this->fileInfo['error'] );
                return false;
            }
            return true;
        }
        $this->setErrMsg( $Uploader->getFileInfo( )['error'] );
        return false;
    }
}
?>