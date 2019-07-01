<?php
namespace Aurora\Notification;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

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
        $this->Registry = Registry::getInstance();
        $this->NotificationModel = NotificationModel::getInstance( );

        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Aurora/NavRes');
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
    public function renderNavWindow( ) {
        $vars = array( 'TPLVAR_ID' => 'notifyWindow',
                       'TPLVAR_PREFIX' => 'notify',
                       'LANG_TITLE' => $this->L10n->getContents('LANG_NOTIFICATIONS'),
                       'LANG_BOTTOM_TEXT' => $this->L10n->getContents('LANG_VIEW_ALL') );

        return $this->View->render( 'aurora/notification/html/notifyWindow.tpl', $vars );
    }


    /**
     * Get Navigation Class
     * @return string
     */
    public function getNavClass( $folder, $namespace, $className ) {
        static $nav;
        $class  = $namespace . '\\' . $className;

        if( !isset( $nav[$class] ) ) {
            //File::import( CONTROL . $folder . '/' . $className . '.class.php' );
            $Notification = new $class;
            $nav[$class] = $Notification;
        }
        return $nav[$class];
    }


    /**
     * Return Section
     * @return string
     */
    public function renderWindow( ) {
        $list = $this->NotificationModel->getByUserID( );
        $vars['dynamic']['list'] = false;

        if( sizeof( $list ) == 0 ) {
            $vars['dynamic']['noList'][] = true;
        }
        else {
            $vars['dynamic']['noList'] = false;
            //$UserAvatarView = new UserAvatarView( );

            foreach( $list as $row ) {
                $class = $this->getNavClass( $row['folder'], $row['namespace'], $row['class'] );

                if( $row['popup'] ) {
                    $popup = unserialize( $row['popup'] );
                    $link  = 'Aurora.UI.showBox( \'' . $popup['modalID'] . '\',
                                                 \'' . ROOT_URL . $row['urlpath'] . '\',
                                                 ' . $popup['width'] . ',
                                                 ' . $popup['height'] . ' );';
                }
                else {
                    $link = 'location.href=\'' . ROOT_URL . $row['urlpath'] . '\';';
                }
                $vars['dynamic']['list'][] = array( //'TPL_AVATAR' => $UserAvatarView->renderAvatar( $row, 'micro' ),
                                                    'TPLVAR_MESSAGE' => $class->getNotification( $row ),
                                                    'TPLVAR_LINK' => $link,
                                                    'TPLVAR_DATE_TIME' => \Date::timeSince( strtotime( $row['nuCreated'] ) ) );
            }
        }
        $vars = array_merge( $this->L10n->getContents( ), $vars );
        return $this->View->render( 'aurora/page/notifyList.tpl', $vars );
    }
}
?>