<?php
namespace Markaxis\Leave;
use \Aurora\Admin\AdminView, \Aurora\Component\DesignationModel AS A_DesignationModel;
use \Aurora\Form\SelectListView, \Aurora\Form\SelectGroupListView, \Aurora\Form\RadioView;
use \Aurora\Component\ContractModel AS A_ContractModel, \Aurora\Component\CountryModel;
use \Library\Helper\Aurora\YesNoHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: StructureView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StructureView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $StructureModel;
    protected $A_DesignationModel;
    protected $A_ContractModel;


    /**
    * StructureView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->A_DesignationModel = A_DesignationModel::getInstance( );
        $this->A_ContractModel = A_ContractModel::getInstance( );
        $this->StructureModel = StructureModel::getInstance( );
    }

    /**
     * Render main navigation
     * @return mixed
     */
    public function renderFormVars( ) {
        $SelectGroupListView = new SelectGroupListView( );
        $SelectGroupListView->includeBlank(false );
        $SelectGroupListView->isMultiple(true);

        $designationList = $SelectGroupListView->build('designation', $this->A_DesignationModel->getList( ),
                                                       '','Select Designation' );

        $SelectListView = new SelectListView( );
        $SelectListView->isMultiple(true );
        $SelectListView->includeBlank(false);
        $contractList = $SelectListView->build('contractType', $this->A_ContractModel->getList( ),
                                               '', 'Select Contract Type' );

        $RadioView = new RadioView( );
        $proRatedRadio = $RadioView->build('proRated', YesNoHelper::getL10nList( ), '' );
        $childCareRadio = $RadioView->build('childCare', YesNoHelper::getL10nList( ), '0' );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );

        $SelectListView = new SelectListView( );
        $childCountryList = $SelectListView->build( 'childBorn', $countries, '', 'Select a Country' );
        $childNotCountryList = $SelectListView->build( 'childNotBorn', $countries, '', 'Select a Country' );

        $maxAge = 10;
        $ageList = array( );

        for( $i=1; $i<=$maxAge; $i++ ) {
            $ageList[$i] = $i;
        }
        $childAgeList = $SelectListView->build( 'childAge', $ageList, '', 'Select Child Age' );

        return array( 'TPL_DESIGNATION_LIST' => $designationList,
                      'TPL_CONTRACT_LIST' => $contractList,
                      'TPL_PRO_RATED_RADIO' => $proRatedRadio,
                      'TPL_CHILD_CARE_RADIO' => $childCareRadio,
                      'TPL_CHILD_COUNTRY_LIST' => $childCountryList,
                      'TPL_CHILD_NOT_COUNTRY_LIST' => $childNotCountryList,
                      'TPL_CHILD_AGE_LIST' => $childAgeList );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAddType( ) {
        $vars = array_merge( $this->L10n->getContents( ), $this->renderFormVars( ) );

        $vars['dynamic']['noGroup'] = true;
        $vars['dynamic']['group'] = false;
        return $this->View->render( 'markaxis/leave/structureForm.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEditType( $ltID ) {
        $vars = array_merge( $this->L10n->getContents( ), $this->renderFormVars( ) );

        $vars['dynamic']['noGroup'] = true;
        $vars['dynamic']['group'] = false;
        //$vars['dynamic']['structure'] = false;

        $GroupModel = GroupModel::getInstance( );
        $groupID = 0;

        if( $groupInfo = $GroupModel->getByltID( $ltID ) ) {
            $vars['dynamic']['noGroup'] = false;

            foreach( $groupInfo as $group ) {

                /*$child = '';

                if( $strucInfo = $this->StructureModel->getBydesignationID( $desigGroup['ldID'] ) ) {
                    var_dump($strucInfo); exit;
                    $strucVars = array( );

                    foreach( $strucInfo as $structure ) {
                        $strucVars['dynamic']['row'] = array( 'TPLVAR_ID' => $structureID,
                                                              'TPLVAR_LSID' => $structure['lsID'],
                                                              'TPLVAR_START' => $structure['start'],
                                                              'TPLVAR_END' => $structure['end'],
                                                              'TPLVAR_DAYS' => $structure['days'] );


                        $child .= $this->View->render( 'markaxis/leave/structure.tpl', $strucVars );
                        $structureID++;
                    }
                }*/
                // Group
                $vars['dynamic']['group'][] = array( 'TPLVAR_GID' => $group['lgID'],
                                                     'TPLVAR_INDEX' => $groupID,
                                                     'TPLVAR_GROUP_TITLE' => $group['title'],
                                                     'TPL_GROUP_CHILD' => '' );

                $groupID++;
            }
        }
        return $this->View->render( 'markaxis/leave/structureForm.tpl', $vars );
    }
}
?>