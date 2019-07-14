<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Component\RecruitSourceModel;
use \Library\Helper\Aurora\RelationshipHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AdditionalView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdditionalView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $AdditionalModel;
    protected $info;
    protected $eContactInfo;


    /**
    * AdditionalView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/AdditionalRes');

        $this->AdditionalModel = AdditionalModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAdd( ) {
        $this->info = $this->AdditionalModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $userID ) {
        $existInfo = $this->AdditionalModel->getByUserID( $userID, '*' );
        $this->info = $existInfo ? $existInfo : $this->AdditionalModel->getInfo( );

        $EContactModel = EContactModel::getInstance( );
        $this->eContactInfo = $EContactModel->getByUserID( $userID, '*' );

        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( ) {
        $SelectListView = new SelectListView( );
        $RecruitSourceModel = RecruitSourceModel::getInstance( );
        $rsID = isset( $this->info['rsID'] ) ? $this->info['rsID'] : '';
        $rsList = $SelectListView->build( 'recruitSource',  $RecruitSourceModel->getList( ),
                                            $rsID, 'Select Recruitment Source' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_RS_LIST' => $rsList,
                       'TPLVAR_NOTES' => $this->info['notes'] ) );

        $count = 0;
        if( $this->eContactInfo ) {
            $size = sizeof( $this->eContactInfo );

            for( $i=0; $i<$size; $i++ ) {
                $eRsList = $SelectListView->build( 'eRs_' . $i, RelationshipHelper::getL10nList( ),
                                                    $this->eContactInfo[$i]['relationship'], 'Select Relationship' );

                $vars['dynamic']['econtact'][] = array_merge( $this->L10n->getContents( ),
                                                 array( 'TPLVAR_INDEX' => $i,
                                                        'TPLVAR_COUNT' => $i+1,
                                                        'TPLVAR_ECID' => $this->eContactInfo[$i]['ecID'],
                                                        'TPLVAR_NAME' => $this->eContactInfo[$i]['name'],
                                                        'TPLVAR_PHONE' => $this->eContactInfo[$i]['phone'],
                                                        'TPLVAR_MOBILE' => $this->eContactInfo[$i]['mobile'],
                                                        'TPL_ERS_LIST' => $eRsList ) );
                $count++;
            }
        }

        // At least show 2 input set for eContact.
        $SelectListView->setClass( 'relationship' );

        if( $count < 2 ) {
            for( $i=$count; $i<2; $i++ ) {
                $eRsList = $SelectListView->build( 'eRs_' . $i, RelationshipHelper::getL10nList( ),
                                                    '', 'Select Relationship' );

                $vars['dynamic']['econtact'][] = array_merge( $this->L10n->getContents( ),
                                                 array( 'TPLVAR_INDEX' => $i,
                                                        'TPLVAR_COUNT' => $i+1,
                                                        'TPLVAR_ECID' => '',
                                                        'TPLVAR_NAME' => '',
                                                        'TPLVAR_PHONE' => '',
                                                        'TPLVAR_MOBILE' => '',
                                                        'TPL_ERS_LIST' => $eRsList ) );
            }
        }
        return $this->View->render( 'markaxis/employee/additionalForm.tpl', $vars );
    }
}
?>