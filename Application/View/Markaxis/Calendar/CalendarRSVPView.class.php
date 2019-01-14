<?php
namespace Markaxis\Calendar;
use \Library\Runtime\Registry, Aurora\LightboxView;
use Aurora\UserAvatarView, Aurora\UserMultiListView, Aurora\RoleSelectListView, Aurora\UserRoleModel;
use \Library\IO\File;
use \MXString;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarRSVPView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarRSVPView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $View;
    protected $L10n;
    protected $CalendarRSVPModel;


    /**
    * CalendarRSVPView Constructor
    * @return void
    */
    function __construct( CalendarRSVPModel $CalendarRSVPModel ) {
        $this->Registry = Registry::getInstance( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Calendar/RSVPRes');

        $this->View = LightboxView::getInstance( );
        $this->CalendarRSVPModel = $CalendarRSVPModel;
        $this->View->setJScript( array( 'markaxis.rsvp.i18n' => 'locale/' . $this->L10n->getL10n( ) ) );
	}


    /**
    * Get Notification
    * @return str
    */
    public function getNotification( $info ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
        $CalendarModel = CalendarModel::getInstance( );
        $CalendarModel->loadEvent( $info['refID'] );
        $eventInfo = $CalendarModel->getInfo( );

        if( sizeof( $eventInfo ) > 0 ) {
            $str = $this->L10n->getText('LANG_INVITE_TO', $eventInfo['gender'], '', array( '{n}=="m"' ) );
            $str = str_replace( '{username}', $eventInfo['fname'] . ' ' . $eventInfo['lname'], $str );
            $str = str_replace( '{event}', $eventInfo['title'], $str );

            if( $eventInfo['address'] ) {
                $str .= ' ' . $this->L10n->getContents('LANG_LOCATED_AT');
            }
            return $str;
        }
    }


    /**
    * Render Tab
    * @return str
    */
    public function renderTab( ) {
        $vars = array( 'TPVAR_TAB_ID' => 'rsvp',
                       'LANG_TITLE'   => $this->L10n->getContents('LANG_RSVP') );

        return $this->View->render( 'markaxis/calendar/html/tab.tpl', $vars );
    }


    /**
    * Return RSVP form
    * @return str
    */
    public function renderForm( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $data   = $CalendarModel->getInfo('data');
        $rsvpID = '';

        if( $data['eventID'] > 0 ) {
            $attendee = $this->CalendarRSVPModel->getByEventID( $data['eventID'] );

            if( sizeof( $attendee ) > 0 ) {
                while( list( , $row ) = each( $attendee ) ) {
                    $rsvpID .= $row['userID'] . ',';
                }
                $rsvpID = substr( $rsvpID, 0, -1 );
            }
        }

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_RSVP_ID' => $rsvpID ) );

        $this->View->setJScript( array( 'markaxis.rsvp' => 'markaxis/calendar/markaxis.rsvp.js' ) );
        return $this->View->render( 'markaxis/calendar/html/rsvpForm.tpl', $vars );
    }


    /**
    * AJAX Call for Role List
    * @return void
    */
    public function renderRoles( ) {
        File::import( VIEW . 'Aurora/View.class.php' );
        File::import( VIEW . 'Aurora/Form/SelectListView.class.php' );
        File::import( VIEW . 'Aurora/Form/RoleSelectListView.class.php' );
        $RoleSelectListView = new RoleSelectListView( );
        $RoleSelectListView->setClass('selectList');
        return $RoleSelectListView->getList( '', true, $this->L10n->getContents('LANG_SELECT_ROLE') );
    }


    /**
    * Render user list
    * @return void
    */
    public function renderUserList( $post ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        $excludeUserID = array( $userInfo['userID'] );

        File::import( MODEL . 'Aurora/User/UserRoleModel.class.php' );
        $UserRoleModel = UserRoleModel::getInstance( );

        if( $post['rsvpType'] == 'name' && $post['rsvpInput'] != '' ) {
            $userList = $UserRoleModel->searchByNameEmail( $post['rsvpInput'], 0, $post['currPage'], 20, $excludeUserID );
        }
        else if( $post['rsvpType'] == 'role' && $post['rsvpInput'] > 0 ) {
            $userList = $UserRoleModel->searchByNameEmail( '', $post['rsvpInput'], $post['currPage'], 20, $excludeUserID );
        }
        else {
            $userList = $UserRoleModel->getUsers( $post['currPage'], 20, $excludeUserID );
        }

        File::import( VIEW . 'Aurora/Form/MultiListView.class.php' );
        File::import( VIEW . 'Aurora/Form/UserMultiListView.class.php' );
        $UserMultiListView = new UserMultiListView( );
        $UserMultiListView->setClass( 'rsvpList' );
        return array( 'pages' => (int)ceil( $userList['total']/20 ),
                      'count' => $userList['total'],
                      'html'  => $UserMultiListView->build( 'users', $userList ) );
    }


    /**
    * Render Agenda Tab
    * @return str
    */
    public function renderAgendaTab( ) {
        $vars = array( 'TPVAR_TAB_ID' => 'agendaRSVP',
                       'LANG_TITLE'   => $this->L10n->getContents('LANG_RSVP_COMMENTS') );
        return $this->View->render( 'markaxis/calendar/html/tab.tpl', $vars );
    }


    /**
    * Render Agenda
    * @return str
    */
    public function renderAgendaData( $eventInfo ) {
        $info = $this->CalendarRSVPModel->getByEventID( $eventInfo['eventID'] );
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $i = 1;
        $userStatus    = 0;
        $isInvited     = false;
        $attending     = '';
        $notAttending  = '';
        $maybe         = '';
        $notYetReplied = '';

        File::import( VIEW . 'Aurora/User/UserAvatarView.class.php' );
        $UserAvatarView = new UserAvatarView( );

        while( list(  , $row ) = each( $info ) ) {
            if( $row['userID'] == $userInfo['userID'] ) {
                $isInvited  = true;
                $userStatus = $row['attending'];
            }
            if( $row['attending'] == 1 ) {
                $attending .= $UserAvatarView->renderSmallUserList( $row, 'micro' );
            }
            if( $row['attending'] == 0 ) {
                $notYetReplied .= $UserAvatarView->renderSmallUserList( $row, 'micro' );
            }
            if( $row['attending'] == '-1' ) {
                $notAttending .= $UserAvatarView->renderSmallUserList( $row, 'micro' );
            }
            if( $row['attending'] == 2 ) {
                $maybe .= $UserAvatarView->renderSmallUserList( $row, 'micro' );
            }
            $i++;
        }
        // hidden field
        $vars['TPLVAR_USER_STATUS'] = $userStatus;
        $vars['TPL_ATTENDING']      = $attending;
        $vars['TPL_NOT_ATTENDING']  = $notAttending;
        $vars['TPL_MAYBE']          = $maybe;
        $vars['TPL_NOT_REPLIED']    = $notYetReplied;

        $vars['dynamic']['rsvpBtn'] = false;
        if( $isInvited ) {
            $vars['dynamic']['rsvpBtn'][] = true;
        }

        File::import( MODEL . 'Markaxis/Feed/FeedModel.class.php' );
        $FeedModel = new FeedModel( );
        $FeedModel->setTable( 'markaxis_rsvp_feed' );

        File::import( VIEW . 'Markaxis/Feed/FeedView.class.php' );
        $FeedView = new FeedView( $FeedModel );
        $vars['TPL_FEED'] = $FeedView->renderFeed( 'AND eventID = "' . (int)$eventInfo['eventID'] . '"' );

        $vars = array_merge( $this->L10n->getContents( ), $vars );

        $this->View->setJScript( array( 'markaxis.feed.res'   => 'locale/Markaxis/FeedRes.js',
                                        'markaxis.feedSystem' => 'markaxis/feed/markaxis.feedSystem.js',
                                        'markaxis.rsvp' => 'markaxis/calendar/markaxis.agendaRSVP.js',
                                        'jquery.textexpand'  => 'jquery/jquery.ui.textexpand.js' ) );

        $this->View->setStyle( array( 'markaxis/calendar' => 'agendaRSVP' ) );
        return $this->View->render( 'markaxis/calendar/html/agendaRSVP.tpl', $vars );
    }
}
?>