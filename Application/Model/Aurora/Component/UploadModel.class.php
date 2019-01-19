<?php
namespace Aurora\Component;
use \Library\IO\File;
use \Library\Exception\Aurora\PageNotFoundException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UploadModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UploadModel extends \Model {


    // Properties
    protected $Upload;


    /**
     * UploadModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');

        $this->Upload = new Upload( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $uID, $hashName ) {
        return $this->Upload->isFound( $uID, $hashName );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUIDHashName( $uID, $hashName ) {
        return $this->Upload->getByUIDHashName( $uID, $hashName );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByUID( $uID ) {
        return $this->Upload->getByUID( $uID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Upload->getList( );
    }


    /**
     * Create an attachment entry
     * @return int
     */
    public function view( $args ) {
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            if( $fileInfo = $this->getByUIDHashName( $args[1], $args[2] ) ) {
                $filename = ROOT . UPLOAD_DIR . '/' . $fileInfo['hashDir'] . '/' . $fileInfo['hashName'];

                if( file_exists( $filename ) ) {
                    $mimeType = File::getType( $filename );
                    $content = file_get_contents( $filename );
                    header('Content-Type: ' . $mimeType);
                    header('Content-Length: '.strlen( $content ));
                    header('Content-disposition: inline; filename="' . $fileInfo['name'] . '"');
                    header('Cache-Control: public, must-revalidate, max-age=0');
                    header('Pragma: public');
                    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
                    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                    echo $content;
                    exit;
                }
            }
        }
        throw( new PageNotFoundException( HttpResponse::HTTP_NOT_FOUND ) );
    }


    /**
     * Create an attachment entry
     * @return int
     */
    public function saveUpload( $fileInfo ) {
        if( isset( $fileInfo['name'] ) ) {
            $info = array( );
            $info['name']     = $fileInfo['name'];
            $info['hashName'] = $fileInfo['hashName'];
            $info['hashDir']  = $fileInfo['hashDir'];
            $info['size']     = $fileInfo['size'];
            $info['created']  = date( 'Y-m-d H:i:s' );
            return $this->Upload->insert( 'upload', $info );
        }
        return false;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function deleteFile( $uID, $hashName, $dir ) {
        if( $fileInfo = $this->getByUIDHashName( $uID, $hashName ) ) {
            unlink( $dir . $fileInfo['hashDir'] . $fileInfo['hashName'] );

            if( File::dirIsEmpty( $dir . $fileInfo['hashDir'] ) ) {
                File::removeDir( $dir . $fileInfo['hashDir'] );
            }

            $this->Upload->delete( 'upload', 'WHERE uID = "' . (int)$uID . '"' );
            return true;
        }
        return false;
    }


    /**
     * Returns a file size limit in bytes based on the PHP upload_max_filesize and post_max_size
     * @return int
     */
    public function maxUploadSize( ) {
        $maxSize = -1;

        if( $maxSize < 0 ) {
            $postMaxSize = $this->parseSize( ini_get('post_max_size' ) );
            if( $postMaxSize > 0 ) {
                $maxSize = $postMaxSize;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $uploadMax = $this->parseSize( ini_get('upload_max_filesize' ) );
            if( $uploadMax > 0 && $uploadMax < $maxSize ) {
                $maxSize = $uploadMax;
            }
            return $this->formatBytes( $maxSize );
        }
    }


    /**
     * Returns a file size limit in bytes based on the PHP upload_max_filesize and post_max_size
     * @return int
     */
    public function parseSize( $size ) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size ); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size ); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0] ) ) );
        }
        else {
            return round( $size );
        }
    }


    public function getBase64Size( $base64Image ) {
        return $this->formatBytes( strlen( rtrim( $base64Image, '=' ) ) * 3 / 4 );
    }


    /**
     * Returns a file size limit in bytes based on the PHP upload_max_filesize and post_max_size
     * @return int
     */
    public function formatBytes( $bytes ) {
        if( $bytes < 1024 ) return $bytes.' B';
        else if( $bytes < 1048576 ) return round( $bytes / 1024, 2 ) . ' KB';
        else if( $bytes < 1073741824 ) return round( $bytes / 1048576, 2 ) . ' MB';
        else if( $bytes < 1099511627776 ) return round( $bytes / 1073741824, 2 ) . ' GB';
        else return round( $bytes / 1099511627776, 2 ) . ' TB';
    }
}
?>