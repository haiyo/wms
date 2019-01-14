<?php
namespace Markaxis\Calendar;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarAttachmentControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarAttachmentControl {


    // Properties


    /**
    * CalendarAttachmentControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Get a single event
    * @return void
    */
    public function getEvent( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $eventInfo = $CalendarModel->getInfo( );

        if( $eventInfo['eventID'] > 0 && $eventInfo['attachment'] ) {
            File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
            $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );

            File::import( VIEW . 'Aurora/AuroraView.class.php' );
            File::import( VIEW . 'Aurora/LightboxView.class.php' );
            File::import( VIEW . 'Markaxis/Calendar/CalendarAttachmentView.class.php' );
            $CalendarAttachmentView = new CalendarAttachmentView( $CalendarAttachmentModel );
            $vars = array( );
            // Run tabData first as we need fileInfo cache for tab count :D
            $vars['tabData'] = $CalendarAttachmentView->renderAgendaData( $eventInfo );
            $vars['tab']     = $CalendarAttachmentView->renderAgendaTab( );
            Control::setOutputArrayAppend( $vars );
        }
    }


    /**
    * Iterate through events and count attachment
    * @return void
    
    public function getEvents( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
        $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );
        Control::setOutputArray( $CalendarAttachmentModel->iterateCount( Control::getOutputArray( ) ) );
    }*/


    /**
    * Iterate through events and count attachment
    * @return void
    */
    public function getRecurs( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
        $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );
        Control::setOutputArray( $CalendarAttachmentModel->iterateRecurCount( Control::getOutputArray( ) ) );
    }


    /**
    * Attachment Form View
    * @return void
    */
    public function newEvent( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
        $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarAttachmentView.class.php' );
        $CalendarAttachmentView = new CalendarAttachmentView( $CalendarAttachmentModel );
        Control::setOutputArrayAppend( array( 'tab'  => $CalendarAttachmentView->renderTab( ),
                                              'data' => $CalendarAttachmentView->renderData( ) ) );
    }


    /**
    * Attachment Form View
    * @return void
    */
    public function editEvent( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
        $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarAttachmentView.class.php' );
        $CalendarAttachmentView = new CalendarAttachmentView( $CalendarAttachmentModel );
        Control::setOutputArrayAppend( array( 'tab'  => $CalendarAttachmentView->renderTab( ),
                                              'data' => $CalendarAttachmentView->renderData( ) ) );
    }


    /**
    * Delete Attachment
    * @return void
    */
    public function deleteAtt( ) {
        $post = Control::getRequest( )->request( POST );
        
        File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
        $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );
        $CalendarAttachmentModel->deleteAtt( $post['attID'] );
        exit;
    }


    /**
    * Upload Attachment
    * @return void
    */
    public function attach( ) {
        // COR not enabled
        //header('Access-Control-Allow-Origin: *');
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Pragma: no-cache' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );
        header( 'X-Content-Type-Options: nosniff' );
        header( 'Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size' );

        $vars = array( );
        $vars['bool'] = 0;
        $post = Control::getRequest( )->request( POST  );
        $file = Control::getRequest( )->request( FILES );

        File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
        $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );

        if( isset( $post['calID'] ) && isset( $post['eventID'] ) && isset( $file['file'] ) ) {
            if( $CalendarAttachmentModel->uploadSuccess( $post['calID'], $post['eventID'], $file['file'] ) ) {
                $vars = $CalendarAttachmentModel->getFileInfo( );
                if( $vars['success'] == 2 ) {
                    $CalendarAttachmentModel->newAttachment( $post['calID'], $post['eventID'] );
                }
            }
            else {
                 $vars['errMsg'] = $CalendarAttachmentModel->getErrMsg( );
            }
            echo json_encode( $vars );
            exit;
        }
    }


    /**
    * View Attachment
    * @return void
    */
    public function viewAtt( $param ) {
        if( isset( $param[1] ) && is_numeric( $param[1] ) ) {
            File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
            $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );
            $fileInfo = $CalendarAttachmentModel->getAttachment( $param[1] );

            if( $fileInfo ) {
                header( 'Content-Type: ' . $fileInfo['mimeType'] );
                header( 'Expires: 0' );
                header( 'Cache-Control: must-revalidate' );
                header( 'Content-Length: ' . filesize( $fileInfo['filePath'] ) );
                ob_clean( );
                flush( );
                readfile( $fileInfo['filePath'] );
                exit;
            }
        }
    }


    /**
    * Download Attachment
    * @return void
    */
    public function download( $param ) {
        if( isset( $param[1] ) && is_numeric( $param[1] ) ) {
            File::import( MODEL . 'Markaxis/Calendar/CalendarAttachmentModel.class.php' );
            $CalendarAttachmentModel = CalendarAttachmentModel::getInstance( );
            $fileInfo = $CalendarAttachmentModel->getAttachment( $param[1] );
            if( $fileInfo ) {
                header( 'Content-Description: File Transfer' );
                header( 'Content-Type: application/octet-stream' );
                header( 'Expires: ' . gmdate('D, d M Y H:i:s', gmmktime( ) - 3600) . ' GMT' );
                header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
                header( 'Content-Disposition: attachment; filename="' . $fileInfo['name'] . '"' );
                header( 'Content-Transfer-Encoding: binary' );
                header( 'Content-Length: ' . filesize( $fileInfo['filePath'] ) );
                ob_clean( );
                flush( );
                readfile( $fileInfo['filePath'] );
                exit;
            }
        }
    }
}
?>