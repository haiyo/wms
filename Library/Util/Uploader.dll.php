<?php
namespace Library\Util;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, June 12, 2012
 * @version $Id: Uploader.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Uploader {


    /**
    */
    protected $option;
    protected $fileInfo;
    /**
    * On validation pass, this will be set to true to prevent
    * unnecessary subsequent call of is_uploaded_file( );
    */
    private $isUploadedFile = false;


    /**
    * Uploader Constructor
    * @return void
    */
    public function __construct( $options=null ) {
        $this->options = array(
            'uploadDir' => '',
            'tmpFolder' => 'tmp/',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'maxFileSize' => null,
            'minFileSize' => 1,
            //How to restrict the file selection dialog to show only specific file types?
            //<input type="file" name="files[]" accept="image/png" multiple>
            'acceptFileTypes' => '/.+$/i',
            // Set the following option to false to enable resumable uploads:
            'discardAbort' => false
        );
        if( $options ) {
            $this->options = array_replace_recursive( $this->options, $options );
        }

        $this->options['hashDir'] = MD5( date('Y-m-d') );
        $this->fileInfo['uploadDir'] = $this->options['uploadDir'] . $this->options['hashDir'] . '/';

        if( !is_dir( $this->fileInfo['uploadDir'] ) ) {
            File::createDir( $this->fileInfo['uploadDir'] );
        }
    }
    
    
    /**
    * Get File Information
    * @return mixed
    */
    public function getFileInfo( ) {
        return $this->fileInfo;
    }


    /**
    * Rename filename which already exist in the server with an extension
    * @return string
    */
    protected function upCountName( $matches ) {
        $index = isset( $matches[1] ) ? (int)$matches[1] + 1 : 1;
        $ext   = isset( $matches[2] ) ? $matches[2] : '';
        return '_' . $index . $ext;
    }
    

    /**
    * Normalize filename and prevent filename crashes
    * @return string
    */
    protected function trimFileName( $name, $type ) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $fileName = trim( basename( stripslashes( strip_tags( $name ) ) ), ".\x00..\x20" );

        // Add missing file extension for known image types:
        if( strpos( $fileName, '.' ) === false && preg_match( '/^image\/(gif|jpe?g|png)/', $type, $matches ) ) {
            $fileName .= '.' . $matches[1];
        }
        if( $this->options['discardAbort'] ) {
            while( is_file( $this->options['uploadDir'] . $fileName ) ) {
                $fileName = preg_replace_callback( '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/',
                                                    array($this, 'upCountName'), $fileName, 1 );
            }
        }
        return $fileName;
    }


    /**
    * Performs file validation
    * @return bool
    */
    public function validate( $file ) {
        $this->fileInfo['tmp_name'] = isset( $file['tmp_name'] ) ? $file['tmp_name'] : null;
        $this->fileInfo['name']     = isset( $_SERVER['HTTP_X_FILE_NAME'] ) ? $_SERVER['HTTP_X_FILE_NAME'] :
                                    ( isset( $file['name'] ) ? $file['name'] : null );
        $this->fileInfo['size']     = (int)isset( $_SERVER['HTTP_X_FILE_SIZE'] ) ? $_SERVER['HTTP_X_FILE_SIZE'] :
                                    ( isset( $file['size'] ) ? $file['size'] : null );
        $this->fileInfo['type']     = isset( $_SERVER['HTTP_X_FILE_TYPE'] ) ? $_SERVER['HTTP_X_FILE_TYPE'] :
                                    ( isset( $file['type'] ) ? $file['type'] : null );
        $this->fileInfo['error']    = isset( $file['error'] ) ? $file['error'] : null;

        if( !is_dir( $this->options['uploadDir'] ) ) {
            $this->fileInfo['error'] = 'Upload directory not found!';
            return false;
        }
        if( !is_writable( $this->options['uploadDir'] ) ) {
            $this->fileInfo['error'] = 'Upload directory permission insufficient to write file!';
            return false;
        }
        if( !$this->fileInfo['name'] ) {
            $this->fileInfo['error'] = 'missingFileName';
            return false;
        }
        if( !preg_match( $this->options['acceptFileTypes'], $this->fileInfo['name'] ) ) {
            $this->fileInfo['error'] = 'acceptFileTypes';
            return false;
        }
        // Get chunksize first
        if( $this->fileInfo['tmp_name'] && is_uploaded_file( $this->fileInfo['tmp_name'] ) ) {
            $this->fileInfo['chunkSize'] = filesize( $this->fileInfo['tmp_name'] );
            $this->isUploadedFile = true;
        }
        else {
            $this->fileInfo['chunkSize'] = $_SERVER['CONTENT_LENGTH'];
        }
        if( $this->options['maxFileSize'] && ( $this->fileInfo['chunkSize'] > $this->options['maxFileSize'] ||
                                               $this->fileInfo['size'] > $this->options['maxFileSize'] ) ) {
            $this->fileInfo['error'] = 'maxFileSize';
            return false;
        }
        if( $this->options['minFileSize'] && $this->fileInfo['chunkSize'] < $this->options['minFileSize'] ) {
            $this->fileInfo['error'] = 'minFileSize';
            return false;
        }

        $this->fileInfo['name'] = $this->trimFileName( $this->fileInfo['name'], $this->fileInfo['type'] );
        $this->fileInfo['hashDir'] = $this->options['hashDir'];
        $this->fileInfo['isImage'] = preg_match( '/([^\s]+(\.(?i)(jpg|png|gif|bmp))$)/', $this->fileInfo['name'] );
        File::createDir( $this->fileInfo['uploadDir'] . $this->options['tmpFolder'] );
        return true;
    }
    

    /**
    * Perform upload to folder
    * @return bool
    */
    public function upload( ) {
        $filePath = $this->fileInfo['uploadDir'] . $this->options['tmpFolder'] . $this->fileInfo['name'];
        $appendFile = !$this->options['discardAbort'] && is_file( $filePath ) && $this->fileInfo['size'] > filesize( $filePath );
        clearstatcache( );

        if( $this->isUploadedFile ) {
            if( $appendFile ) {
                file_put_contents( $filePath, fopen( $this->fileInfo['tmp_name'], 'r' ), FILE_APPEND );
            }
            else {
                move_uploaded_file( $this->fileInfo['tmp_name'], $filePath );
            }

            @chmod( $filePath, 0777 );
            $fileSize = filesize( $filePath );

            if( $fileSize !== $this->fileInfo['size'] && $this->options['discardAbort'] ) {
                unlink( $filePath );
                $this->fileInfo['error'] = 'abort';
                return false;
            }
            if( $fileSize == $this->fileInfo['size'] ) {
                $salt = uniqid( mt_rand( ), true );
                $this->fileInfo['hashName'] = MD5( microtime( ) . $salt ) . '.' . pathinfo( $this->fileInfo['name'], PATHINFO_EXTENSION );


                rename( $filePath, $this->fileInfo['uploadDir'] . $this->fileInfo['hashName'] );
                File::removeDir( $this->fileInfo['uploadDir'] . $this->options['tmpFolder'] );
                $this->fileInfo['success'] = 2;
                return true;
            }
            //$this->fileInfo['test'] = $fileSize . '==' . $this->fileInfo['size'];
            $this->fileInfo['size'] = $fileSize;
            $this->fileInfo['success'] = 1;
            return true;
        }
        return false;
    }
}
?>