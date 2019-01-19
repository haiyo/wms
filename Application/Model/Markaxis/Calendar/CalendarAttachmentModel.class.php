<?php
namespace Markaxis\Calendar;
use \Uploader, \ImageManipulation;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalendarAttachmentModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarAttachmentModel extends \Model {


    // Properties
    protected $fileInfo;
    protected $uploadPath;

    const THUMBNAIL_WIDTH  = 32;
    const THUMBNAIL_HEIGHT = 32;


    /**
    * CalendarAttachmentModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->uploadPath = ROOT . UPLOAD_DIR . 'markaxis/calendar/';
	}


    /**
    * Get File Information
    * @return mixed
    */
    public function getFileInfo( ) {
        return $this->fileInfo;
    }


    /**
    * Get event
    * @return bool
    */
    public function getByEventID( $eventID ) {
        File::import( DAO . 'Markaxis/Calendar/CalendarAttachment.class.php' );
        $CalendarAttachment = new CalendarAttachment( );
        return $CalendarAttachment->getByEventID( $eventID );
    }


    /**
    * Retrieve attachment
    * @return str
    */
    public function getAttachment( $attID ) {
        File::import( DAO . 'Markaxis/Calendar/CalendarAttachment.class.php' );
        $CalendarAttachment = new CalendarAttachment( );
        $fileInfo = $CalendarAttachment->getByID( $attID );

        if( $fileInfo ) {
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            if( $fileInfo['userID'] == $userInfo['userID'] || $fileInfo['privacy'] == 0 ) {
                $fileInfo['filePath'] = $this->dir . $fileInfo['hashDir'] . '/' . $fileInfo['hashName'];
                if( file_exists( $fileInfo['filePath'] ) ) {
                    $fileInfo['mimeType'] = File::getType( $fileInfo['filePath'] );
                    return $fileInfo;
                }
            }
        }
        return false;
    }


    /**
    * Iterate through events and count num of attachment
    * @return mixed
    */
    public function iterateCount( $eventInfo ) {
        if( sizeof( $eventInfo ) > 0 ) {
            File::import( DAO . 'Markaxis/Calendar/CalendarAttachment.class.php' );
            $CalendarAttachment = new CalendarAttachment( );
            while( list( $key, $row ) = each( $eventInfo ) ) {
                if( $row['attachment'] ) {
                    $eventInfo[$key]['attachNum'] = $CalendarAttachment->countByEventID( $row['eventID'] );
                }
            }
        }
        return $eventInfo;
    }


    /**
    * Iterate through events and insert attachment count
    * @return mixed
    */
    public function iterateRecurCount( $eventInfo ) {
        if( isset( $eventInfo['data'] ) ) {
            File::import( DAO . 'Markaxis/Calendar/CalendarAttachment.class.php' );
            $CalendarAttachment = new CalendarAttachment( );
            $countCache = array( );

            while( list( $key, $eventArray ) = each( $eventInfo['data'] ) ) {
                while( list( $key2, $row ) = each( $eventArray ) ) {
                    if( $row['attachment'] ) {
                        if( !isset( $countCache[$row['eventID']] ) ) {
                            $countCache[$row['eventID']] = $CalendarAttachment->countByEventID( $row['eventID'] );
                        }
                        $eventArray[$key2]['attachNum'] = $countCache[$row['eventID']];
                    }
                }
                $eventInfo['data'][$key] = $eventArray;
            }
        }
        return $eventInfo;
    }


    /**
    * Upload file
    * @return bool
    */
    public function uploadSuccess( $calID, $eventID, $file ) {
        $this->fileInfo['hashDir'] = MD5( date('Y-m-d') );
        $this->fileInfo['dir'] = (int)$calID . '/' . (int)$eventID . '/' . $this->fileInfo['hashDir'] . '/';
        
        File::createDir( $this->uploadPath . (int)$calID );
        File::createDir( $this->uploadPath . (int)$calID . '/' . (int)$eventID );
        File::createDir( $this->uploadPath . $this->fileInfo['dir'] );
        
        File::import( LIB . 'Util/Uploader.dll.php' );
        $Uploader = new Uploader( array( 'uploadDir' => $this->uploadPath . $this->fileInfo['dir'] ) );
        if( $Uploader->validate( $file ) ) {
            $Uploader->upload( );
        }

        $this->fileInfo = array_merge( $this->fileInfo, $Uploader->getFileInfo( ) );

        if( $this->fileInfo['error'] ) {
            $this->setErrMsg( $this->fileInfo['error'] );
            return false;
        }

        if( $this->fileInfo['success'] == 2 && $this->fileInfo['isImage'] ) {
            $this->processResize( );
        }
        /*
        switch( $this->fileInfo['error'] ) {
            case 'missingFileName' :
            $this->setErrMsg( $this->MessageRes->getContents('LANG_INVALID_MESSAGE') );
            break;
        }*/
        return true;
	}


    /**
    * Process Image Resize
    * @return void
    */
    public function processResize( ) {
        $fileInfo = explode( '.', $this->fileInfo['hashName'] );
        $this->fileInfo['thumbnail']  = $this->fileInfo['dir'] . '/' . $fileInfo[0] . '_thumbnail.'  . $fileInfo[1];

        File::import( LIB . 'Util/ImageManipulation.dll.php' );
        $ImageManipulation = new ImageManipulation( $this->Registry->get( HKEY_LOCAL, 'imageLib' ) );
        $ImageManipulation->autoRotate( $this->uploadPath . $this->fileInfo['dir'] . '/' . $this->fileInfo['hashName'] );
        $ImageManipulation->copyResized( $this->uploadPath . $this->fileInfo['dir'] . '/' . $this->fileInfo['hashName'],
                                         $this->uploadPath . $this->fileInfo['thumbnail'],
                                         self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, false );
    }


    /**
    * Create an attachment entry
    * @return int
    */
    public function newAttachment( $calID, $eventID ) {
        $info = array( );
        $info['calID']    = (int)$calID;
        $info['eventID']  = (int)$eventID;
        $info['name']     = $this->fileInfo['name'];
        $info['hashName'] = $this->fileInfo['hashName'];
        $info['hashDir']  = $this->fileInfo['hashDir'];
        $info['size']     = $this->fileInfo['size'];
        $info['created']  = date( 'Y-m-d H:i:s' );

        File::import( DAO . 'Markaxis/Calendar/CalendarAttachment.class.php' );
        $CalendarAttachment = new CalendarAttachment( );
        $this->fileInfo['attID'] = $CalendarAttachment->insert( 'markaxis_event_attachment', $info );
        
        $info2 = array( );
        $CalendarAttachment->updateCustom( 'markaxis_event', 'attachment=attachment+1', 'WHERE eventID = "' . (int)$info['eventID'] . '"' );
        return $this->fileInfo['attID'];
	}


    /**
    * Delete attachment
    * @param $force - if set to true, userID will not be check
    * @return bool
    */
    public function deleteAtt( $fileInfo, $force=false ) {
        File::import( DAO . 'Markaxis/Calendar/CalendarAttachment.class.php' );
        $CalendarAttachment = new CalendarAttachment( );
        if( is_numeric( $fileInfo ) ) {
            $fileInfo = $CalendarAttachment->getByID( $fileInfo );
        }

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( $fileInfo ) {
            if( !$force && $fileInfo['userID'] != $userInfo['userID'] ) {
                return false;
            }
            unlink( $this->uploadPath . $fileInfo['calID'] . '/' . $fileInfo['eventID'] . '/' . $fileInfo['hashDir'] . '/' . $fileInfo['hashName'] );
            $CalendarAttachment->delete( 'markaxis_event_attachment', 'WHERE attID = "' . (int)$fileInfo['attID'] . '"' );

            $info = array( );
            $info['attachment'] = $CalendarAttachment->countByEventID( $fileInfo['eventID'] );
            $CalendarAttachment->update( 'markaxis_event', $info, 'WHERE eventID = "' . (int)$fileInfo['eventID'] . '"' );

            // Check if any file still exist in current dir, if not remove dir.
            if( $info['attachment'] == 0 ) {
                File::removeDir( $this->uploadPath . $fileInfo['calID'] . '/' . $fileInfo['eventID'] . '/' . $fileInfo['hashDir'] );
            }
            if( File::dirIsEmpty( $this->uploadPath . $fileInfo['calID'] . '/' . $fileInfo['eventID'] ) ) {
                File::removeDir( $this->uploadPath . $fileInfo['calID'] . '/' . $fileInfo['eventID'] );
            }
            if( File::dirIsEmpty( $this->uploadPath . $fileInfo['calID'] ) ) {
                File::removeDir( $this->uploadPath . $fileInfo['calID'] );
            }
            return true;
        }
        return false;
    }


    /**
    * Delete all by CalID
    * @return bool
    */
    public function deleteAllFilesByCalID( $calID ) {
        File::removeDir( $this->uploadPath . (int)$calID );
    }


    /**
    * Delete all by EventID
    * @return bool
    */
    public function deleteAllFilesByEventID( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $info = $CalendarModel->getInfo( );
        File::removeDir( $this->uploadPath . (int)$info['calID'] . '/' . (int)$info['eventID'] );

        if( File::dirIsEmpty( $this->uploadPath . (int)$info['calID'] . '/' ) ) {
            File::removeDir( $this->uploadPath . (int)$info['calID'] . '/' );
        }
    }
}
?>