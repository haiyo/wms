<?php
namespace Aurora\Notification;
use \Aurora\Admin\AdminView, \Aurora\User\UserImageModel;
use \Library\Runtime\Registry, \Library\Util\Date;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NotificationView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NotificationView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $Authorization;
    protected $NotificationModel;


    /**
     * NotificationView Constructor
     * @return void
     */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->NotificationModel = NotificationModel::getInstance( );

        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Aurora/Notification/NotificationRes');
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderMenuIcon( ) {
        $count = $this->NotificationModel->getUnreadCount( );

        $vars = array( 'TPLVAR_CLASS_NAME' => 'notifyIco flagIco',
                       'TPL_WINDOW' => $this->renderNavWindow( ),
                       'TPLVAR_CLASS' => 'notifyCounter',
                       'TPLVAR_DISPLAY' => $count ? '' : 'none',
                       'TPLVAR_COUNT' => $count );

        return $this->View->render( 'aurora/navigation/html/navParentIcon.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderWindow( ) {
        $vars = array_merge( $this->L10n->getContents( ), array( ) );
        $list = $this->NotificationModel->getByUserID( );

        $vars['dynamic']['noList'][] = true;
        $vars['dynamic']['list'] = false;

        if( sizeof( $list ) > 0 ) {
            $vars['dynamic']['noList'] = false;

            $UserImageModel = UserImageModel::getInstance( );

            foreach( $list as $row ) {
                $vars['dynamic']['list'][] = array( 'TPLVAR_PHOTO' => $UserImageModel->getImgLinkByUserID( $row['userID'] ),
                                                    'TPLVAR_URL' => $row['url'],
                                                    'TPLVAR_MESSAGE' => $row['message'],
                                                    'TPLVAR_DATE_TIME' => Date::timeSince( $row['created'] ) );
            }
        }
        return $this->View->render( 'aurora/notification/window.tpl', $vars );
    }


    /**
     * Return Section
     * @return string
     */
    public function renderList( ) {
        $list = $this->NotificationModel->getByUserID( );

        $vars['dynamic']['noList'][] = true;
        $vars['dynamic']['list'] = false;

        if( sizeof( $list ) > 0 ) {
            $vars['dynamic']['noList'] = false;
            //$UserAvatarView = new UserAvatarView( );

            foreach( $list as $row ) {
                $vars['dynamic']['list'][] = array( //'TPL_AVATAR' => $UserAvatarView->renderAvatar( $row, 'micro' ),
                                                    'TPLVAR_URL' => $row['url'],
                                                    'TPLVAR_MESSAGE' => $row['message'],
                                                    'TPLVAR_DATE_TIME' => Date::timeSince( strtotime( $row['created'] ) ) );
            }
        }
        $vars = array_merge( $this->L10n->getContents( ), $vars );
        return $this->View->render( 'aurora/notification/notifyList.tpl', $vars );
    }
}
?>