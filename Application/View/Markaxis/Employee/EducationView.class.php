<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView, \Library\Helper\Aurora\MonthHelper, \Aurora\Form\SelectListView;
use \Aurora\Component\CountryModel, \Aurora\Component\UploadModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EducationView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EducationView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $EducationModel;
    protected $info;


    /**
    * EducationView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/EmployeeRes');

        $this->EducationModel = EducationModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAdd( ) {
        $this->info = $this->EducationModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $userID ) {
        $existInfo = $this->EducationModel->getByUserID( $userID, '*' );
        $this->info = $existInfo ? $existInfo : $this->EducationModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( ) {
        $SelectListView = new SelectListView( );
        $eduFromMonthList = $SelectListView->build( 'eduFromMonth', MonthHelper::getL10nShortList( ), '', 'Month' );
        $eduToMonthList = $SelectListView->build( 'eduToMonth', MonthHelper::getL10nShortList( ), '', 'Month' );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );
        $eduCountryList  = $SelectListView->build( 'eduCountry', $countries, '', 'Choose a Country' );

        $vars = array( 'TPL_EDU_COUNTRY_LIST' => $eduCountryList,
                        'TPL_EDU_FROM_MONTH_LIST' => $eduFromMonthList,
                        'TPL_EDU_TO_MONTH_LIST' => $eduToMonthList,
                        'TPLVAR_EDU_FROM_YEAR' => '',
                        'TPLVAR_EDU_TO_YEAR' => '' );

        $UploadModel = new UploadModel( );

        $vars['dynamic']['education'] = false;

        if( isset( $this->info[0] ) ) {
            $size = sizeof( $this->info );

            for( $i=0; $i<$size; $i++ ) {
                $fromDate = explode( '-', $this->info[$i]['fromDate'] );
                $toDate = explode( '-', $this->info[$i]['toDate'] );

                $fromDateStr = MonthHelper::getL10nShortList()[$fromDate[1]] . ' ' . $fromDate[0];
                $toDateStr = MonthHelper::getL10nShortList()[$toDate[1]] . ' ' . $toDate[0];

                $uID = $fileName = $hashName = $showFile = $showUpload = $showDelete = '';

                if( $this->info[$i]['uID'] ) {
                    if( $fileInfo = $UploadModel->getByUID( $this->info[$i]['uID'] ) ) {
                        $uID = $fileInfo['uID'];
                        $fileName = $fileInfo['name'];
                        $hashName = $fileInfo['hashName'];
                        $showFile = '';
                        $showUpload = 'none';
                    }
                }
                else {
                    $showFile = $showDelete = 'none';
                }

                $vars['dynamic']['education'][] = array( 'TPLVAR_SCHOOL' => $this->info[$i]['school'],
                                                         'TPLVAR_COUNTRY' => $this->info[$i]['country'],
                                                         'TPLVAR_LEVEL' => $this->info[$i]['level'],
                                                         'TPLVAR_SPECIALIZE' => $this->info[$i]['specialization'],
                                                         'TPLVAR_FROM_MONTH' => $fromDate[1],
                                                         'TPLVAR_FROM_YEAR' => $fromDate[0],
                                                         'TPLVAR_TO_MONTH' => $toDate[1],
                                                         'TPLVAR_TO_YEAR' => $toDate[0],
                                                         'TPLVAR_FROM_DATE' => $fromDateStr,
                                                         'TPLVAR_TO_DATE' => $toDateStr,
                                                         'TPLVAR_EDU_ID' => $this->info[$i]['eduID'],
                                                         'TPLVAR_UID' => $uID,
                                                         'TPLVAR_HASHNAME' => $hashName,
                                                         'TPLVAR_FILENAME' => $fileName,
                                                         'TPLVAR_SHOW_FILE' => $showFile,
                                                         'TPLVAR_SHOW_UPLOAD' => $showUpload,
                                                         'TPLVAR_SHOW_DELETE_FILE' => $showDelete,
                                                         'TPLVAR_MAX_ALLOWED' => $UploadModel->maxUploadSize( ),
                                                         'TPLVAR_INDEX' => $i );
            }
        }
        return $this->View->render( 'markaxis/employee/educationForm.tpl', $vars );
    }
}
?>