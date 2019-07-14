<?php
namespace Markaxis\Leave;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\Component\CountryModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ChildCareView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChildCareView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $ChildCareModel;


    /**
    * ChildCareView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->ChildCareModel = ChildCareModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAddType( ) {
        $SelectListView = new SelectListView( );

        $maxAge = 10;
        $ageList = array( );

        for( $i=1; $i<=$maxAge; $i++ ) {
            $ageList[] = $i;
        }
        $CountryModel = CountryModel::getInstance( );
        $childCountryList = $SelectListView->build( 'childCountry', $CountryModel->getList( ), '', 'Select Country' );
        $childMaxAgeList = $SelectListView->build( 'childMaxAge', $i, '', 'Select Age' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_CHILD_COUNTRY_LIST' => $childCountryList,
                       'TPL_CHILD_MAX_AGE_LIST' => $childMaxAgeList ) );

        return $this->View->render( 'markaxis/leave/childCareForm.tpl', $vars );
    }
}
?>