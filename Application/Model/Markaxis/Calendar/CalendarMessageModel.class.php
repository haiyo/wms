<?php
namespace Markaxis\Calendar;
use \Library\IO\File;
use Aurora\MessageModel, Aurora\User\UserRoleModel;
use \IObserver;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalendarMessageModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarMessageModel extends \Model implements IObserver {


    // Properties


    /**
    * CalendarMessageModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Calendar/EventRes');
	}


    /**
    * Performs message actions
    * @return void
    */
    public function init( $sender, $action ) {
        //$this->$action( $sender );
	}


    /**
    * Set approval
    * @return void
    */
    public function setApproval( $sender ) {
        $info = $sender->getInfo( );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'fname, lname' );

        File::import( MODEL . 'Aurora/User/MessageModel.class.php' );
        $MessageModel = MessageModel::getInstance( );
        $msgInfo = $MessageModel->getByNotificationID( $info['eventID'] );
        $message = unserialize( $msgInfo['message'] );
        $className = $info['approve'] == 1 ? 'green' : 'red';
        $approve = $info['approve'] == 1 ? $this->L10n->getContents('LANG_APPROVED_BY') :
                                           $this->L10n->getContents('LANG_DISAPPROVED_BY');
        $message = $message['message'] . '<div class="eventTitle ' . $className . '">' . $approve . ' ' . $userInfo['fname'] . ' ' . $userInfo['lname'] . '</div>';
        $MessageModel->setNotificationArchive( $info['eventID'], $message );
    }


    /**
    * Add new message
    * @return void
    */
    public function add( $sender ) {
        $info = $sender->getInfo( );
        if( !$info['approve'] ) {
            $setInfo = $sender->getSetInfo( );
            $setInfo['approvalRoles'][] = 1; // Add in Administrator Role

            File::import( MODEL . 'Aurora/User/MessageModel.class.php' );
            $MessageModel = MessageModel::getInstance( );

            File::import( MODEL . 'Aurora/User/UserRoleModel.class.php' );
            $UserRoleModel = UserRoleModel::getInstance( );

            //$Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            //$fromUserID = $Authenticator->getUserModel( )->getInfo( 'userID' );

            $elements = array( );
            $elements['message'] = '<style>.eventTime { margin-top:5px; }.eventTitle { font-weight:bold; }.red {margin-top:5px;color:#e60000;}.green{margin-top:5px;color:#529214;}</style>' .
                                   $info['descript'] .
                                   '<div class="eventTime">' .
                                   '<span class="eventTitle">' . $this->L10n->getContents('LANG_START') . ':</span> ' . $info['start'] . ' - ' .
                                   '<span class="eventTitle">' . $this->L10n->getContents('LANG_END')   . ':</span> ' . $info['end'] . '</div>';
            $elements['url'] = 'calendar/setApproval';
            $elements['hidden'] = array( 'dropletID' => $info['dropletID'],
                                         'eventID'   => $info['eventID'] );
            $elements['buttons'] = array( $this->L10n->getContents('LANG_APPROVE') => 1,
                                          $this->L10n->getContents('LANG_DISAPPROVE') => 0 );

            while( list( , $roleID ) = each( $setInfo['approvalRoles'] ) ) {
                $userIDs = $UserRoleModel->getByRoleID( $roleID );

                while( list( , $toUserInfo ) = each( $userIDs ) ) {
                    $MessageModel->sendNew( $toUserInfo['userID'], $info['userID'],
                                            $this->L10n->getContents('LANG_SUBJECT'),
                                            serialize( $elements ),
                                            $info['eventID'] );
                }
            }
        }
	}
}
?>