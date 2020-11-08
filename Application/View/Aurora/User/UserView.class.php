<?php
namespace Aurora\User;
use \Aurora\Admin\AdminView, \Aurora\Form\RadioView, \Aurora\Form\SelectListView, \Aurora\Form\DayIntListView;
use \Library\Helper\Aurora\GenderHelper, \Library\Helper\Aurora\IDTypeHelper, \Library\Helper\Aurora\YesNoHelper;
use \Library\Helper\Aurora\MonthHelper;
use \Library\Helper\Aurora\MaritalHelper, \Aurora\Component\NationalityModel;
use \Aurora\Component\CountryModel, \Aurora\Component\ReligionModel, \Aurora\Component\RaceModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $UserModel;
    protected $userInfo;


    /**
    * UserView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Aurora/User/UserRes');

        // We'll be doing user setup so make sure we use a new model instead of instance.
        $this->UserModel = new UserModel( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function setInfo( $userInfo ) {
        $this->userInfo = $userInfo;
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderProfile( ) {
        $this->userInfo = $this->UserModel->getCurrUser( );

        return array( 'userInfo' => $this->userInfo,
                      'form' => $this->renderForm( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAdd( ) {
        $this->userInfo = $this->UserModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $userInfo ) {
        $this->userInfo = $userInfo;
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( ) {
        $RadioView = new RadioView( );
        $genderRadio = $RadioView->build('gender', GenderHelper::getL10nList( ), $this->userInfo['gender'] );
        $childrenRadio = $RadioView->build('children', YesNoHelper::getL10nList( ), $this->userInfo['children'] );

        $dobDay = $dobMonth = $dobYear = '';
        if( $this->userInfo['birthday'] ) {
            $birthday = explode( '-', $this->userInfo['birthday'] );
            $dobDay   = $birthday[2];
            $dobMonth = $birthday[1];
            $dobYear  = $birthday[0];
        }
        $DayIntListView = new DayIntListView( );
        $SelectListView = new SelectListView( );
        $dobDayList   = $DayIntListView->getList('dobDay', $dobDay, $this->L10n->getContents('LANG_DAY') );
        $dobMonthList = $SelectListView->build('dobMonth', MonthHelper::getL10nList( ), $dobMonth,
                                                $this->L10n->getContents('LANG_MONTH') );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );
        $countryList = $SelectListView->build( 'country', $countries, $this->userInfo['countryID'],
                                                $this->L10n->getContents('LANG_SELECT_COUNTRY') );

        $langList = $SelectListView->build('language', $this->i18n->getLanguages( ), $this->userInfo['lang'],
                                               $this->L10n->getContents('LANG_SELECT_LANGUAGE') );

        $idTypeList = $SelectListView->build( 'idType', IDTypeHelper::getL10nList( ), $this->userInfo['idType'],
            $this->L10n->getContents('LANG_SELECT_ID_TYPE') );

        $NationalityModel = NationalityModel::getInstance( );
        $nationalities = $NationalityModel->getList( );
        $nationalityList = $SelectListView->build( 'nationality', $nationalities, $this->userInfo['nationalityID'],
                                                    $this->L10n->getContents('LANG_SELECT_NATIONALITY') );

        $SelectListView->setClass( 'maritalList' );
        $maritalList  = $SelectListView->build( 'marital', MaritalHelper::getL10nList( ), $this->userInfo['marital'],
                                                $this->L10n->getContents('LANG_SELECT_STATUS') );

        $ReligionModel = ReligionModel::getInstance( );
        $religionID = isset( $this->userInfo['religionID'] ) ? $this->userInfo['religionID'] : '';
        $religionList = $SelectListView->build( 'religion', $ReligionModel->getList( ), $religionID,
                                                $this->L10n->getContents('LANG_SELECT_RELIGION') );

        $RaceModel = RaceModel::getInstance( );
        $raceID = isset( $this->userInfo['raceID'] ) ? $this->userInfo['raceID'] : '';
        $SelectListView->setClass( 'raceList' );
        $raceList = $SelectListView->build( 'race',  $RaceModel->getList( ), $raceID, $this->L10n->getContents('LANG_SELECT_RACE') );

        $SelectListView->setClass('childSelect childCountry' );
        $childCountry  = $SelectListView->build( 'childCountry_{id}', $countries, '',
                                                 $this->L10n->getContents('LANG_SELECT_COUNTRY') );

        $DayIntListView->setClass('childSelect childDobDay' );
        $childDOBDayList = $DayIntListView->getList( 'childDobDay_{id}', '', 'Day' );

        $SelectListView->setClass('childSelect childDobMonth' );
        $childDOBMonthList = $SelectListView->build( 'childDobMonth_{id}', MonthHelper::getL10nList( ), '',
                                                     $this->L10n->getContents('LANG_MONTH') );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_USERID' => $this->userInfo['userID'],
                       'TPLVAR_FNAME' => $this->userInfo['fname'],
                       'TPLVAR_LNAME' => $this->userInfo['lname'],
                       'TPLVAR_NRIC' => $this->userInfo['nric'],
                       'TPLVAR_USERNAME' => $this->userInfo['username'],
                       'TPLVAR_EMAIL' => $this->userInfo['email'],
                       'TPLVAR_PHONE' => $this->userInfo['phone'],
                       'TPLVAR_MOBILE' => $this->userInfo['mobile'],
                       'TPLVAR_DOB_YEAR' => $dobYear,
                       'TPLVAR_HOUSE_NO' => $this->userInfo['houseNo'],
                       'TPLVAR_STREET_NAME' => $this->userInfo['streetName'],
                       'TPLVAR_LEVEL_UNIT' => $this->userInfo['levelUnit'],
                       'TPL_LANGUAGE_LIST' => $langList,
                       'TPLVAR_POSTAL' => $this->userInfo['postal'],
                       'TPLVAR_CITY' => $this->userInfo['city'],
                       'TPLVAR_STATE' => $this->userInfo['state'],
                       'TPL_IDTYPE_LIST' => $idTypeList,
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
                       'TPL_CHILD_DOB_MONTH_LIST' => $childDOBMonthList ) );

        $vars['dynamic']['children'] = false;

        if( $this->userInfo['userID'] ) {
            $ChildrenModel = new ChildrenModel( );

            $id = 0;
            if( $ucInfo = $ChildrenModel->getByUserID( $this->userInfo['userID'] ) ) {
                foreach( $ucInfo as $value ) {
                    $countryList  = $SelectListView->build('childCountry_' . $id, $countries, $value['country'],
                                                            $this->L10n->getContents('LANG_SELECT_COUNTRY') );

                    $birthday = explode( '-', $value['birthday'] );
                    $dobDay   = $birthday[2];
                    $dobMonth = $birthday[1];
                    $dobYear  = $birthday[0];

                    $dobDayList   = $DayIntListView->getList( 'childDobDay_' . $id, $dobDay, 'Day' );
                    $dobMonthList = $SelectListView->build( 'childDobMonth_' . $id, MonthHelper::getL10nList( ), $dobMonth,
                                                            $this->L10n->getContents('LANG_MONTH') );

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
        }
        return $this->View->render( 'aurora/user/form.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderLog( $userID ) {
        $vars = array( 'TPLVAR_USERID' => $userID );
        return $this->View->render( 'aurora/employee/log.tpl', $vars );
    }
}
?>