<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView, \Library\Helper\Aurora\MonthHelper, \Aurora\Form\SelectListView;
use \Aurora\Component\UploadModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ExperienceView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExperienceView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $ExperienceModel;
    protected $info;


    /**
    * ExperienceView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/EmployeeRes');

        $this->ExperienceModel = ExperienceModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAdd( ) {
        $this->info = $this->ExperienceModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderEdit( $userID ) {
        $existInfo = $this->ExperienceModel->getByUserID( $userID, '*' );
        $this->info = $existInfo ? $existInfo : $this->ExperienceModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderForm( ) {
        $SelectListView = new SelectListView( );
        $expFromMonthList = $SelectListView->build( 'expFromMonth', MonthHelper::getL10nShortList( ), '', 'Month' );
        $expToMonthList = $SelectListView->build( 'expToMonth', MonthHelper::getL10nShortList( ), '', 'Month' );

        $vars = array( 'TPL_EXP_FROM_MONTH_LIST' => $expFromMonthList,
                       'TPL_EXP_TO_MONTH_LIST' => $expToMonthList,
                       'TPLVAR_EXP_FROM_YEAR' => '',
                       'TPLVAR_EXP_TO_YEAR' => '' );

        $UploadModel = new UploadModel( );

        $vars['dynamic']['experience'] = false;

        if( isset( $this->info[0] ) ) {
            $size = sizeof( $this->info );

            for( $i=0; $i<$size; $i++ ) {
                $fromDate = explode( '-', $this->info[$i]['fromDate'] );
                $toDate = explode( '-', $this->info[$i]['toDate'] );

                $fromDateStr = MonthHelper::getL10nShortList()[$fromDate[1]] . ' ' . $fromDate[0];
                $toDateStr = MonthHelper::getL10nShortList()[$toDate[1]] . ' ' . $toDate[0];

                $uID = $fileName = $hashName = $showFile = $showUpload = $showDelete = '';

                if( $this->info[$i]['testimonial'] ) {
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

                $vars['dynamic']['experience'][] = array( 'TPLVAR_COMPANY' => $this->info[$i]['company'],
                                                          'TPLVAR_DESIGNATION' => $this->info[$i]['designation'],
                                                          'TPLVAR_DESCRIPTION' => $this->info[$i]['description'],
                                                          'TPLVAR_FROM_MONTH' => $fromDate[1],
                                                          'TPLVAR_FROM_YEAR' => $fromDate[0],
                                                          'TPLVAR_TO_MONTH' => $toDate[1],
                                                          'TPLVAR_TO_YEAR' => $toDate[0],
                                                          'TPLVAR_FROM_DATE' => $fromDateStr,
                                                          'TPLVAR_TO_DATE' => $toDateStr,
                                                          'TPLVAR_EXP_ID' => $this->info[$i]['expID'],
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
        return $this->render( 'markaxis/employee/experienceForm.tpl', $vars );
    }
}
?>