<?php
namespace Markaxis\Calendar;
use Registry, Aurora\LightboxView, Aurora\IconDisplay;
use \MXString;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarAttachmentView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarAttachmentView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $View;
    protected $L10n;
    protected $CalendarAttachmentModel;

    protected $fileCount = 0;


    /**
    * CalendarAttachmentView Constructor
    * @return void
    */
    function __construct( CalendarAttachmentModel $CalendarAttachmentModel ) {
        $this->Registry = Registry::getInstance( );
        $this->View = LightboxView::getInstance( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Calendar/AttachmentRes');
        $this->CalendarAttachmentModel = $CalendarAttachmentModel;

        $this->View->setJScript( array( 'markaxis.attachment.i18n' => 'locale/' . $this->L10n->getL10n( ) ) );
	}


    /**
    * Render Tab
    * @return str
    */
    public function renderTab( ) {
        $vars = array( 'TPVAR_TAB_ID' => 'attach',
                       'LANG_TITLE'   => $this->L10n->getContents('LANG_CLICK_BROWSE') );

        return $this->View->render( 'markaxis/calendar/html/tab.tpl', $vars );
    }


    /**
    * Return attachment form
    * @return str
    */
    public function renderData( ) {
        $totalSize  = ini_get( 'post_max_size' );
        $uploadSize = ini_get( 'upload_max_filesize' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_TOTAL_B'    => MXString::strToBytes( ($totalSize+1) . 'M' ),
                       'TPLVAR_TOTAL_TXT'  => $totalSize,
                       'TPLVAR_UPLOAD_B'   => MXString::strToBytes( $uploadSize ),
                       'TPLVAR_UPLOAD_TXT' => $uploadSize ) );

        $CalendarModel = CalendarModel::getInstance( );
        $data = $CalendarModel->getInfo('data');

        if( isset( $data['attachment'] ) && $data['attachment'] > 0 ) {
            $attList = $this->CalendarAttachmentModel->getByEventID( $data['eventID'] );

            while( list( , $row ) = each( $attList ) ) {
                $vars['dynamic']['attList'][] = array_merge( $this->L10n->getContents( ),
                                                array( 'TPLVAR_ATTID' => $row['attID'],
                                                       'TPLVAR_NAME'  => String::cropFilename( $row['name'], 55 ),
                                                       'TPLVAR_SIZE'  => String::bytesToStr( $row['size'] ) ) );
            }
        }
        else {
            $vars['dynamic']['attList'] = false;
        }

        $this->View->setJScript( array( 'aurora.uploader' => 'aurora/aurora.uploader.js',
                                        'markaxis.attachment' => 'markaxis/calendar/markaxis.attachment.js' ) );
        return $this->View->render( 'markaxis/calendar/html/attachmentForm.tpl', $vars );
    }


    /**
    * Render Agenda Tab
    * @return str
    */
    public function renderAgendaTab( ) {
        $vars = array( 'TPVAR_TAB_ID' => 'agendaAttachment',
                       'LANG_TITLE'   => $this->L10n->getContents('LANG_ATTACHMENTS') . ' (<span id="fileCount">' . $this->fileCount . '</span>)' );

        return $this->View->render( 'markaxis/calendar/html/tab.tpl', $vars );
    }


    /**
    * Render Agenda
    * @return str
    */
    public function renderAgendaData( $eventInfo ) {
        $info = $this->CalendarAttachmentModel->getByEventID( $eventInfo['eventID'] );
        $this->fileCount = sizeof( $info );
        $html = '';
        $totalSize = 0;

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo  = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        $deletable = $userInfo['userID'] == $eventInfo['userID'] ? true : false;

        $IconDisplay = new IconDisplay( );
        $IconDisplay->setThumbnailDir( ROOT . UPLOAD_DIR . 'markaxis/calendar/' .
                                       (int)$eventInfo['calID'] . '/' .
                                       (int)$eventInfo['eventID'] . '/' );

        $i = 1;
        while( list(  , $row ) = each( $info ) ) {
            $iconInfo = $IconDisplay->getIcon( $row );

            $totalSize += $row['size'];
            $vars['dynamic']['attachment'][] = array_merge( $this->L10n->getContents( ),
                                               array( 'TPLVAR_ATTID'     => $row['attID'],
                                                      'TPLVAR_NAME'      => String::cropFilename( $row['name'], 55 ),
                                                      'TPLVAR_SIZE'      => String::bytesToStr( $row['size'] ),
                                                      'TPLVAR_ICO'       => $iconInfo['icon'],
                                                      'TPLVAR_VIEWABLE'  => $iconInfo['viewable'] ? '' : 'none',
                                                      'TPLVAR_DELETABLE' => $deletable ? '' : 'none',
                                                      'TPLVAR_LAST_RULE' => $i == $this->fileCount ? 'none' : '' ) );
            $i++;
        }
        $this->View->setStyle( array( 'markaxis/calendar' => 'agendaAttachment' ) );
        $this->View->setJScript( array( 'markaxis.agendaAttachment' => 'markaxis/calendar/markaxis.agendaAttachment.js' ) );
        return $this->View->render( 'markaxis/calendar/html/agendaAttachment.tpl', $vars );
    }
}
?>