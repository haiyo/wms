<?php
namespace Aurora\Page;
use \Aurora\Admin\AdminView, \Aurora\User\UserImageModel;
use \Markaxis\Company\CompanyModel, \Markaxis\Employee\EmployeeModel, \Markaxis\Employee\DesignationModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DashboardView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DashboardView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $L10n;
    protected $View;
    protected $DashboardModel;


    /**
     * DashboardView Constructor
     * @return void
     */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get(HKEY_LOCAL);
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $i18n->loadLanguage('Aurora/Page/DashboardRes');

        $this->View->setJScript( array( 'pages' => 'dashboard.js',
                                        'plugins' => array( 'moment/moment.min.js' ),
                                        'plugins/visualization' => array( 'd3/d3.min.js', 'd3/d3_tooltip.js' ) ) );

        $this->View->setStyle( array( 'core' => 'dashboard' ) );

        $this->DashboardModel = DashboardModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/dashboard',
                       'TPLVAR_CLASS_NAME' => $css,
                       'LANG_LINK' => $this->L10n->getContents('LANG_DASHBOARD') );

        /*
        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
        if( $Authorization->hasPermission( 'Aurora', 'change_logo' ) ) {
            $vars['dynamic']['logoTools'][] = true;
        }*/

        return $this->View->render( 'aurora/menu/parentLink.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSearchbox( array $output ) {
        if( isset( $output['balance'] ) ) {
            $sizeof = sizeof( $output['balance'] );

            if( $sizeof > 0 ) {
                $vars = array_merge( $this->L10n->getContents( ), array( ) );

                for( $i=0; $i<$sizeof; $i++ ) {
                    $vars['TPLVAR_LEAVE_LTID_' . $i] = $output['balance'][$i]['ltID'];
                    $vars['TPLVAR_LEAVE_TYPE_NAME_' . $i] = $output['balance'][$i]['name'];
                    $vars['TPLVAR_LEAVE_BAL_' . $i] = (float)$output['balance'][$i]['balance'];
                }
                return $this->View->render( 'aurora/page/searchBox.tpl', $vars );
            }
        }
        return '';
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderDashboard( $output ) {
        $CompanyModel = CompanyModel::getInstance( );
        $companyInfo = $CompanyModel->getInfo( );

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        $DesignationModel = DesignationModel::getInstance( );
        $dInfo = $DesignationModel->getBydID( $empInfo['designationID'] );

        if( $dInfo ) {
            $designation = $dInfo['title'];
        }
        else {
            $designation = '';
        }

        $UserImageModel = UserImageModel::getInstance( );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_DASHBOARD_BG_COLOR' => $companyInfo['dashboardBgColor'],
                       'TPLVAR_MAIN_COLOR' => $companyInfo['mainColor'],
                       'TPLVAR_PHOTO' => $UserImageModel->getImgLinkByUserID( $empInfo['userID'] ),
                       'TPLVAR_FNAME' => $empInfo['fname'],
                       'TPLVAR_LNAME' => $empInfo['lname'],
                       'TPLVAR_DESIGNATION' => $designation ) );

        $vars['TPL_SIDEBAR_SEARCH_BOX'] = $this->renderSearchbox( $output );

        $vars['TPL_SIDEBAR_CARDS'] = '';
        if( isset( $output['sidebarCards'] ) ) {
            $vars['TPL_SIDEBAR_CARDS'] = $output['sidebarCards'];
        }

        $vars['TPL_CONTENT'] = '';
        if( isset( $output['content'] ) ) {
            $vars['TPL_CONTENT'] = $output['content'];
        }
        if( isset( $output['js'] ) ) {;
            $this->View->setJScript( $output['js'] );
        }
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-home2',
                                            'text' => $this->L10n->getContents('LANG_DASHBOARD') ) );

        $this->View->printAll( $this->View->render( 'aurora/page/dashboard.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderPendingAction( $data ) {
        $vars['TPL_ROW'] = $data;
        return $this->View->render( 'aurora/page/tableRequest.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderRequest( $data ) {
        $vars['TPL_ROW'] = $data;
        return $this->View->render( 'aurora/page/tableRequest.tpl', $vars );
    }
}
?>