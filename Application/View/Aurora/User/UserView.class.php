<?php
namespace Aurora\User;
use \Aurora\Admin\AdminView, \Aurora\Form\RadioView, \Aurora\Form\SelectListView, \Aurora\Form\DayIntListView;
use \Library\Helper\Aurora\GenderHelper, \Library\Helper\Aurora\YesNoHelper, \Library\Helper\Aurora\MonthHelper;
use \Library\Helper\Aurora\MaritalHelper, \Library\Helper\Aurora\NationalityHelper;
use \Aurora\Component\CountryModel, \Aurora\Component\ReligionModel, \Aurora\Component\RaceModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $UserModel;
    protected $info;


    /**
    * UserView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Aurora/User/UserRes');

        // We'll be doing user setup so make sure we use a new model instead of instance.
        $this->UserModel = new UserModel( );

        $this->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js' ),
                                  'plugins/forms/' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js' ),
                                  'pages' => 'wizard_stepy.js',
                                  'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAdd( ) {
        $this->info = $this->UserModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderEdit( $userID ) {
        if( $this->info = $this->UserModel->getFieldByUserID( $userID, '*' ) ) {
            return $this->renderForm( );
        }
        //throw( new PageNotFoundException( HttpResponse::HTTP_NOT_FOUND ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderForm( ) {
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
        }
        return $this->render( 'aurora/user/form.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderLog( $userID ) {
        $vars = array( 'TPLVAR_USERID' => $userID );
        return $this->render( 'aurora/employee/log.tpl', $vars );
    }
}
?>