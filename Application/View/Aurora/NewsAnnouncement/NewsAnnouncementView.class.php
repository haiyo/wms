<?php
namespace Aurora\NewsAnnouncement;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NewsAnnouncementView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncementView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $Authorization;
    protected $NotificationModel;


    /**
     * NewsAnnouncementView Constructor
     * @return void
     */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->NewsAnnouncementModel = NewsAnnouncementModel::getInstance( );

        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Aurora/NewsAnnouncement/NewsAnnouncementRes');
    }


    /**
     * Render Tab
     * @return string
     */
    public function renderNewsAnnouncement( ) {
        $vars = array_merge( $this->L10n->getContents( ), array( ) );

        $vars['dynamic']['noList'] = true;

        if( $list = $this->NewsAnnouncementModel->getList( ) ) {
            $vars['dynamic']['noList'] = false;

            foreach( $list as $row ) {
                $ico = $row['isNews'] ? 'description' : 'announcement';

                $vars['dynamic']['list'][] = array( 'TPLVAR_ICO' => $ico,
                                                    'TPLVAR_TITLE' => $row['title'],
                                                    'TPLVAR_DATE' => $row['created'] );
            }
        }
        return $this->View->render( 'aurora/newsAnnouncement/sideCard.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderList( ) {
        $this->View->setBreadcrumbs( array( 'link' => 'admin/newsAnnouncement/list',
                                            'icon' => 'mi-description',
                                            'text' => $this->L10n->getContents('LANG_NEWS_ANNOUNCEMENT') ) );

        $this->View->setJScript( array( 'locale' => $this->L10n->getL10n( ),
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( 'LANG_LINK' => $this->L10n->getContents('LANG_NEWS_ANNOUNCEMENT') ) );

        $vars['dynamic']['addEmployeeBtn'] = false;

        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
        if( $Authorization->hasPermission( 'Markaxis', 'add_modify_employee' ) ) {
            $vars['dynamic']['addEmployeeBtn'] = true;
        }

        $this->View->printAll( $this->View->render( 'aurora/newsAnnouncement/list.tpl', $vars ) );
    }
}
?>