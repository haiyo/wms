<?php
namespace Aurora\User;
use \Aurora\Admin\AdminView, \Aurora\Form\RadioView, \Aurora\Form\SelectListView, \Aurora\Form\DayIntListView;
use \Library\Helper\Aurora\GenderHelper, \Library\Helper\Aurora\YesNoHelper, \Library\Helper\Aurora\MonthHelper;
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
        $genderRadio = $RadioView->build( 'gender', GenderHelper::getL10nList( ), $this->userInfo['gender'] );
        $childrenRadio = $RadioView->build( 'children', YesNoHelper::getL10nList( ), $this->userInfo['children'] );

        $dobDay = $dobMonth = $dobYear = $startYear = $endYear = '';
        if( $this->userInfo['birthday'] ) {
            $birthday = explode( '-', $this->userInfo['birthday'] );
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
        $countryList = $SelectListView->build( 'country', $countries, $this->userInfo['countryID'], 'Select Country' );

        $NationalityModel = NationalityModel::getInstance( );
        $nationalities = $NationalityModel->getList( );
        $nationalityList = $SelectListView->build( 'nationality', $nationalities, $this->userInfo['nationalityID'], 'Select Nationality' );

        $SelectListView->setClass( 'maritalList' );
        $maritalList  = $SelectListView->build( 'marital', MaritalHelper::getL10nList( ), $this->userInfo['marital'], 'Select Status' );

        $ReligionModel = ReligionModel::getInstance( );
        $religionID = isset( $this->userInfo['religionID'] ) ? $this->userInfo['religionID'] : '';
        $religionList = $SelectListView->build( 'religion', $ReligionModel->getList( ), $religionID, 'Select Religion' );

        $RaceModel = RaceModel::getInstance( );
        $raceID = isset( $this->userInfo['raceID'] ) ? $this->userInfo['raceID'] : '';
        $SelectListView->setClass( 'raceList' );
        $raceList = $SelectListView->build( 'race',  $RaceModel->getList( ), $raceID, 'Select Race' );

        $SelectListView->setClass('childSelect childCountry' );
        $childCountry  = $SelectListView->build( 'childCountry_{id}', $countries, '', 'Select Country' );

        $DayIntListView->setClass('childSelect childDobDay' );
        $childDOBDayList = $DayIntListView->getList( 'childDobDay_{id}', '', 'Day' );

        $SelectListView->setClass('childSelect childDobMonth' );
        $childDOBMonthList = $SelectListView->build( 'childDobMonth_{id}', MonthHelper::getL10nList( ), '', 'Month' );

        $vars = array( 'TPLVAR_USERID' => $this->userInfo['userID'],
                       'TPLVAR_FNAME' => $this->userInfo['fname'],
                       'TPLVAR_LNAME' => $this->userInfo['lname'],
                       'TPLVAR_NRIC' => $this->userInfo['nric'],
                       'TPLVAR_USERNAME' => $this->userInfo['username'],
                       'TPLVAR_EMAIL1' => $this->userInfo['email1'],
                       'TPLVAR_EMAIL2' => $this->userInfo['email2'],
                       'TPLVAR_PHONE' => $this->userInfo['phone'],
                       'TPLVAR_MOBILE' => $this->userInfo['mobile'],
                       'TPLVAR_DOB_YEAR' => $dobYear,
                       'TPLVAR_ADDRESS1' => $this->userInfo['address1'],
                       'TPLVAR_ADDRESS2' => $this->userInfo['address2'],
                       'TPLVAR_POSTAL' => $this->userInfo['postal'],
                       'TPLVAR_CITY' => $this->userInfo['city'],
                       'TPLVAR_STATE' => $this->userInfo['state'],
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

        if( $this->userInfo['userID'] ) {
            $ChildrenModel = new ChildrenModel( );

            $id = 0;
            if( $ucInfo = $ChildrenModel->getByUserID( $this->userInfo['userID'] ) ) {
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