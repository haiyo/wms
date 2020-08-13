<?php
namespace Markaxis\Company;
use \Markaxis\Employee\EmployeeModel, \Markaxis\Employee\ContractModel;
use \Aurora\Component\DesignationModel, \Aurora\Form\SelectGroupListView;
use \Aurora\Admin\AdminView, \Aurora\Component\OfficeModel;
use \Library\Runtime\Registry, \Library\Helper\Aurora\DayHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LOAView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LOAView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $Authorization;
    protected $NotificationModel;


    /**
     * LOAView Constructor
     * @return void
     */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->LOAModel = LOAModel::getInstance( );

        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Company/LOARes');
    }


    /**
     * Render Tab
     * @return mixed
     */
    public function renderLOA( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $CompanyModel = new CompanyModel( );
        $companyInfo = $CompanyModel->loadInfo( );

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        $DesignationModel = DesignationModel::getInstance( );
        $designation = $DesignationModel->getByID( $empInfo['designationID'] )['title'];

        $ContractModel = ContractModel::getInstance( );
        $contractType = $ContractModel->getBycID( $empInfo['contractID'] )['type'];

        $OfficeModel = new OfficeModel( );
        $office = $OfficeModel->getByoID( $empInfo['officeID'] );

        $workDays = DayHelper::getL10nNumericValueList( )[$office['workDayFrom']] . ' - ' .
                    DayHelper::getL10nNumericValueList( )[$office['workDayTo']];

        $workHours = $office['openTime'] . ' - ' . $office['closeTime'];

        $content = $this->LOAModel->getContentByDesignationID( $empInfo['designationID'] );
        $content = str_replace('{fname}', $userInfo['fname'], $content );
        $content = str_replace('{lname}', $userInfo['lname'], $content );
        $content = str_replace('{company_name}', $companyInfo['name'], $content );
        $content = str_replace('{contract_type}', $contractType, $content );
        $content = str_replace('{designation}', $designation, $content );
        $content = str_replace('{emp_start_date}', date('jS F Y', strtotime( $empInfo['startDate'] ) ), $content );
        $content = str_replace('{salary}',$empInfo['currency'] . number_format( $empInfo['salary'],2 ), $content );
        $content = str_replace('{work_days}',$workDays, $content );
        $content = str_replace('{work_hours}',$workHours, $content );

        $logoURL = $CompanyModel->getLogo('slip_uID' );
        $image = file_get_contents( $logoURL );
        $uri = "data:image/png;base64," . base64_encode( $image );

        $vars = array( 'TPLVAR_LOGO' => $uri,
                       'TPLVAR_COMPANY_NAME' => $companyInfo['name'],
                       'TPLVAR_CONTRACT_TYPE' => $contractType,
                       'TPLVAR_CONTENT' => $content );

        $vars['dynamic']['address']   = false;
        $vars['dynamic']['regNumber'] = false;
        $vars['dynamic']['phone']     = false;
        $vars['dynamic']['website']   = false;

        if( $companyInfo['address'] ) {
            $vars['dynamic']['address'][] = array( 'TPLVAR_COMPANY_ADDRESS' => $companyInfo['address'] );
        }

        if( $companyInfo['regNumber'] ) {
            $vars['dynamic']['regNumber'][] = array( 'TPLVAR_COMPANY_REGNUMBER' => $companyInfo['regNumber'] );
        }

        if( $companyInfo['phone'] ) {
            $vars['dynamic']['phone'][] = array( 'TPLVAR_COMPANY_PHONE' => $companyInfo['phone'] );
        }

        if( $companyInfo['website'] ) {
            $vars['dynamic']['website'][] = array( 'TPLVAR_COMPANY_WEBSITE' => $companyInfo['website'] );
        }

        //$html = $this->View->renderHeader( );
        $html = $this->View->render( 'markaxis/company/loa.tpl', $vars );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        require_once LIB . 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( );
        $mpdf->SetDisplayMode(90);
        $mpdf->defaultheaderfontsize = 10;
        $mpdf->defaultheaderfontstyle = '';
        $mpdf->defaultheaderline = 0;
        $mpdf->defaultfooterfontsize = 10;
        $mpdf->defaultfooterfontstyle = '';
        $mpdf->defaultfooterline = 0;

        $mpdf->SetHeader('|STAFF-IN-CONFIDENCE|');
        $mpdf->SetFooter('|STAFF-IN-CONFIDENCE|{PAGENO}');

        $mpdf->SetProtection( array( 'print-highres' ), $Authenticator->getDecrypt( $userInfo ) );
        $mpdf->WriteHTML( $html );
        $mpdf->Output('loa.pdf','I' );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderSettings( ) {
        $this->View->setJScript( array( 'locale' => $this->L10n->getL10n( ),
                                        'jquery' => array( 'jquery.validate.min.js' ),
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js' ),
                                        'plugins/editors' => array( 'ckeditor/ckeditor.js' ),
                                        'markaxis' => array( 'loa.js' ) ) );

        $SelectGroupListView = new SelectGroupListView( );
        $SelectGroupListView->isMultiple(true );
        $SelectGroupListView->includeBlank(false);
        $SelectGroupListView->setClass( '' );

        $DesignationModel = DesignationModel::getInstance( );

        $designationID = isset( $this->info['designationID'] ) ? $this->info['designationID'] : '';
        $designationList = $SelectGroupListView->build('designation', $DesignationModel->getGroupList( ), $designationID,'Filter By Designation' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_HREF' => 'loaList',
                       'TPL_DESIGNATION_LIST' => $designationList,
                       'LANG_TEXT' => $this->L10n->getContents( 'LANG_LETTER_OF_APPOINTMENT' ) ) );

        return array( 'tab'  => $this->View->render( 'aurora/core/tab.tpl', $vars ),
                      'form' => $this->View->render( 'markaxis/company/loaList.tpl', $vars ) );
    }
}
?>