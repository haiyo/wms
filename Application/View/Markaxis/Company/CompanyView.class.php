<?php
namespace Markaxis\Company;
use \Library\Runtime\Registry, \Aurora\Admin\AdminView;
use \Aurora\Component\CountryModel, \Aurora\Form\SelectListView;
use \Aurora\Component\UploadModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CompanyView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $CompanyModel;
    protected $info;


    /**
    * CompanyView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Company/CompanyRes');

        $this->CompanyModel = CompanyModel::getInstance( );

        $this->View->setStyle( array( 'core' => 'croppie' ) );

        $this->View->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js' ),
                                        'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js',
                                                                  'input/typeahead.bundle.min.js', 'input/handlebars.js' ),
                                        'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'picker.time.js' ),
                                        'plugins/uploaders' => array( 'fileinput.min.js', 'croppie.min.js', 'exif.js' ),
                                        'pages' => 'wizard_stepy.js',
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSetup( ) {
        $this->info = $this->CompanyModel->getInfo( );
        $this->View->printAll( $this->renderSetupForm( ), true );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( $data ) {
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-cog3',
                                            'text' => $this->L10n->getContents('LANG_COMPANY_SETTINGS') ) );

        $companyInfo = $this->CompanyModel->loadInfo( );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );

        $SelectListView = new SelectListView( );
        $countryList = $SelectListView->build( 'country', $countries, $companyInfo['countryID'], 'Select Country' );

        $CompanyTypeModel = CompanyTypeModel::getInstance( );
        $companyType = $CompanyTypeModel->getList( );
        $companyTypeList = $SelectListView->build( 'companyType', $companyType, $companyInfo['companyTypeID'], 'Select Company Type' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_HREF' => 'company',
                       'LANG_TEXT' => $this->L10n->getContents('LANG_COMPANY'),
                       'TPLVAR_REG_NUMBER' => $companyInfo['regNumber'],
                       'TPLVAR_NAME' => $companyInfo['name'],
                       'TPLVAR_ADDRESS' => $companyInfo['address'],
                       'TPLVAR_EMAIL' => $companyInfo['email'],
                       'TPLVAR_PHONE' => $companyInfo['phone'],
                       'TPLVAR_WEBSITE' => $companyInfo['website'],
                       'TPL_COMPANY_TYPE_LIST' => $companyTypeList,
                       'TPL_COUNTRY_LIST' => $countryList ) );



        if( $companyInfo['company_uID'] ) {
            $vars['TPLVAR_DEF_COMPANY_LOGO'] = 'hide';
            $vars['dynamic']['companyLogo'][] = array( 'TPLVAR_COMPANY_LOGO' => $this->CompanyModel->getLogo( 'company_uID' ) );
        }
        else {
            $vars['dynamic']['companyLogo'] = false;
        }

        if( $companyInfo['slip_uID'] ) {
            $vars['TPLVAR_DEF_SLIP_LOGO'] = 'hide';
            $vars['dynamic']['slipLogo'][] = array( 'TPLVAR_SLIP_LOGO' => $this->CompanyModel->getLogo( 'slip_uID' ) );
        }
        else {
            $vars['dynamic']['slipLogo'] = false;
        }

        $tab = $this->View->render( 'aurora/core/tab.tpl', $vars );
        $form = $this->View->render( 'markaxis/company/companyForm.tpl', $vars );

        $vars = array( );
        $vars['TPL_TAB'] = $tab . $data['tab'];
        $vars['TPL_FORM'] = $form . $data['form'];

        if( isset( $data['js'] ) ) {
            $this->View->setJScript( $data['js'] );
        }
        $this->View->printAll( $this->View->render( 'markaxis/company/settings.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $userID ) {
        if( $this->info = $this->UserModel->getFieldByUserID( $userID, '*' ) ) {
            return $this->renderForm( );
        }
        //throw( new PageNotFoundException( HttpResponse::HTTP_NOT_FOUND ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSetupForm( ) {
        /*
        $RadioView = new RadioView( );
        $genderRadio = $RadioView->build( 'gender', GenderHelper::getL10nList( ), $this->info['gender'] );
        $childrenRadio = $RadioView->build( 'children', YesNoHelper::getL10nList( ), $this->info['children'] );

        $dobDay = $dobMonth = $dobYear = $startYear = $endYear = '';
        if( $this->info['birthday'] ) {
            $birthday = explode( '-', $this->info['birthday'] );
            $dobDay   = $birthday[2];
            $dobMonth = $birthday[1];
            $dobYear  = $birthday[0];
        }

        $DayIntListView = new DayIntListView( );
        $SelectListView = new SelectListView( );
        $dobDayList   = $DayIntListView->getList( 'dobDay', $dobDay, 'Day' );
        $dobMonthList = $SelectListView->build( 'dobMonth', MonthHelper::getL10nList( ), $dobMonth, 'Month' );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );
        $countryList = $SelectListView->build( 'country', $countries, $this->info['country'], 'Select Country' );

        $SelectListView->setClass( 'maritalList' );
        $maritalList  = $SelectListView->build( 'marital', MaritalHelper::getL10nList( ), $this->info['marital'], 'Select Status' );
        $nationalityList = $SelectListView->build( 'nationality', NationalityHelper::getL10nList( ),
                                                    $this->info['nationality'], 'Select Nationality' );

        $ReligionModel = ReligionModel::getInstance( );
        $religionID = isset( $this->info['religionID'] ) ? $this->info['religionID'] : '';
        $religionList = $SelectListView->build( 'religion', $ReligionModel->getList( ), $religionID, 'Select Religion' );

        $RaceModel = RaceModel::getInstance( );
        $raceID = isset( $this->info['raceID'] ) ? $this->info['raceID'] : '';
        $SelectListView->setClass( 'raceList' );
        $raceList = $SelectListView->build( 'race',  $RaceModel->getList( ), $raceID, 'Select Race' );

        $SelectListView->setClass( 'childSelect' );
        $DayIntListView->setClass( 'childSelect' );
        $childCountry  = $SelectListView->build( 'childCountry_{id}', $countries, '', 'Select Country' );
        $childDOBDayList   = $DayIntListView->getList( 'childDobDay_{id}', $dobDay, 'Day' );
        $childDOBMonthList = $SelectListView->build( 'childDobMonth_{id}', MonthHelper::getL10nList( ), $dobMonth, 'Month' );

        $vars = array( 'TPLVAR_USERID' => $this->info['userID'],
                       'TPLVAR_FNAME' => $this->info['fname'],
                       'TPLVAR_LNAME' => $this->info['lname'],
                       'TPLVAR_NRIC' => $this->info['nric'],
                       'TPLVAR_USERNAME' => $this->info['username'],
                       'TPLVAR_EMAIL1' => $this->info['email1'],
                       'TPLVAR_EMAIL2' => $this->info['email2'],
                       'TPLVAR_PHONE' => $this->info['phone'],
                       'TPLVAR_MOBILE' => $this->info['mobile'],
                       'TPLVAR_DOB_YEAR' => $dobYear,
                       'TPLVAR_ADDRESS1' => $this->info['address1'],
                       'TPLVAR_ADDRESS2' => $this->info['address2'],
                       'TPLVAR_POSTAL' => $this->info['postal'],
                       'TPLVAR_CITY' => $this->info['city'],
                       'TPLVAR_STATE' => $this->info['state'],
                       'TPL_NATIONALITY_LIST' => $nationalityList,
                       'TPL_RELIGION_LIST' => $religionList,
                       'TPL_RACE_LIST' => $raceList,
                       'TPL_MARITAL_LIST' => $maritalList,
                       'TPL_GENDER_RADIO' => $genderRadio,
                       'TPL_DOB_MONTH_LIST' => $dobMonthList,
                       'TPL_DOB_DAY_LIST' => $dobDayList,
                       'TPL_COUNTRY_LIST' => $countryList,
                       'TPL_CHILDREN_RADIO' => $childrenRadio,
                       'TPLVAR_CHILD_NAME' => '',
                       'TPL_CHILD_COUNTRY' => $childCountry,
                       'TPL_CHILD_DOB_DAY_LIST' => $childDOBDayList,
                       'TPL_CHILD_DOB_MONTH_LIST' => $childDOBMonthList );

        $vars['dynamic']['children'] = false;

        if( $this->info['userID'] ) {
            $ChildrenModel = new ChildrenModel( );

            $id = 0;
            if( $ucInfo = $ChildrenModel->getByUserID( $this->info['userID'] ) ) {
                foreach( $ucInfo as $value ) {
                    $countryList  = $SelectListView->build( 'childCountry_' . $id, $countries, $value['country'], 'Select Country' );

                    $birthday = explode( '-', $value['birthday'] );
                    $dobDay   = $birthday[2];
                    $dobMonth = $birthday[1];
                    $dobYear  = $birthday[0];

                    $dobDayList   = $DayIntListView->getList( 'childDobDay_' . $id, $dobDay, 'Day' );
                    $dobMonthList = $SelectListView->build( 'childDobMonth_' . $id, MonthHelper::getL10nList( ), $dobMonth, 'Month' );

                    $vars['dynamic']['children'][] = array( 'TPLVAR_ID' => $id,
                                                            'TPLVAR_UCID' => $value['ucID'],
                                                            'TPLVAR_CHILD_NAME' => $value['name'],
                                                            'TPL_CHILD_COUNTRY' => $countryList,
                                                            'TPL_CHILD_DOB_MONTH_LIST' => $dobMonthList,
                                                            'TPL_CHILD_DOB_DAY_LIST' => $dobDayList,
                                                            'TPLVAR_CHILD_YEAR' => $dobYear );
                    $id++;
                }
            }
        }*/

        $CompanyTypeModel = CompanyTypeModel::getInstance( );
        $companyTypes = $CompanyTypeModel->getList( );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );

        $SelectListView = new SelectListView( );
        $companyTypeList = $SelectListView->build( 'companyType', $companyTypes, $this->info['companyType'], 'Select Company Type' );
        $countryList = $SelectListView->build( 'country', $countries, $this->info['companyCountry'], 'Select Country' );

        $vars = array( 'TPLVAR_REG_NUMBER' => $this->info['companyRegNo'],
                       'TPLVAR_NAME' => $this->info['companyName'],
                       'TPLVAR_ADDRESS' => $this->info['companyAddress'],
                       'TPLVAR_EMAIL' => $this->info['companyEmail'],
                       'TPLVAR_PHONE' => $this->info['companyPhone'],
                       'TPLVAR_WEBSITE' => $this->info['companyWebsite'],
                       'TPL_COUNTRY_LIST' => $countryList,
                       'TPL_TYPE_LIST' => $companyTypeList );

        return $this->View->render( 'markaxis/company/setupForm.tpl', $vars );
    }
}
?>