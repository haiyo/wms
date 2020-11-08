<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView;
use \Aurora\Component\DesignationModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: FormWrapperView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FormWrapperView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $EmployeeModel;
    protected $info;
    protected $formWrapper;


    /**
    * FormWrapperView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/EmployeeRes');

        $this->EmployeeModel = EmployeeModel::getInstance( );

        $this->View->setStyle( array( 'core' => 'croppie' ) );

        $this->View->setJScript( array( 'core' => 'aurora.uploader.js',
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'plugins/uploaders' => array( 'croppie.min.js', 'exif.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ),
                                        'locale' => $this->L10n->getL10n( ) ) );
    }


    /**
     * @return string
     */
    public function renderProfile( $form, $userInfo, $photo ) {
        $this->formWrapper = 'formProfileWrapper';

        $this->View->setTitle( $this->L10n->getContents('LANG_EDIT_PROFILE') );
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-user-plus',
                                            'text' => $this->L10n->getContents('LANG_EDIT_PROFILE') ) );

        $this->View->setJScript( array( 'markaxis' => 'profile.js' ) );

        $this->View->printAll( $this->renderForm( $form, $userInfo, $photo ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAdd( $form ) {
        $this->formWrapper = 'formWrapper';

        $this->View->setTitle( $this->L10n->getContents('LANG_ADD_NEW_EMPLOYEE') );
        $this->View->setBreadcrumbs( array( 'link' => 'admin/employee/add',
                                            'icon' => 'icon-user-plus',
                                            'text' => $this->L10n->getContents('LANG_ADD_NEW_EMPLOYEE') ) );

        $this->View->printAll( $this->renderForm( $form ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $form, $userInfo, $photo ) {
        $this->formWrapper = 'formWrapper';

        $this->View->setTitle( $this->L10n->getContents('LANG_EDIT_EMPLOYEE_INFO') );
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-user-plus',
                                            'text' => $this->L10n->getContents('LANG_EDIT_EMPLOYEE_INFO') ) );

        $this->View->printAll( $this->renderForm( $form, $userInfo, $photo ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( $form, $userInfo=array('userID' => 0), $photo='silhouette' ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_USERID' => $userInfo['userID'],
                       'TPLVAR_THUMBNAIL' => rand(1, 8),
                       'TPLVAR_DEF_PHOTO' => '',
                       'TPL_FORM' => $form ) );

        if( isset( $userInfo['fname'] ) && $userInfo['fname'] ) {
            $vars['dynamic']['name'][] = array( 'TPLVAR_FNAME' => $userInfo['fname'],
                                                'TPLVAR_LNAME' => $userInfo['lname'] );
        }
        else {
            $vars['dynamic']['name'] = false;
        }

        if( isset( $userInfo['email'] ) && $userInfo['email'] ) {
            $vars['dynamic']['email'][] = array( 'TPLVAR_EMAIL' => $userInfo['email'] );
        }
        else {
            $vars['dynamic']['email'] = false;
        }

        if( !strstr( $photo, 'silhouette' ) ) {
            $vars['TPLVAR_DEF_PHOTO'] = 'hide';
            $vars['dynamic']['photo'][] = array( 'TPLVAR_PHOTO' => $photo );
        }
        else {
            $vars['dynamic']['photo'] = false;
        }

        if( isset( $userInfo['phone'] ) && $userInfo['phone'] ) {
            $vars['dynamic']['phone'][] = array( 'TPLVAR_PHONE' => $userInfo['phone'] );
        }
        else {
            $vars['dynamic']['phone'] = false;
        }

        if( isset( $userInfo['mobile'] ) && $userInfo['mobile'] ) {
            $vars['dynamic']['mobile'][] = array( 'TPLVAR_MOBILE' => $userInfo['mobile'] );
        }
        else {
            $vars['dynamic']['mobile'] = false;
        }

        $empInfo = $this->EmployeeModel->getInfo( );

        $vars['dynamic']['designation'] = false;

        if( isset( $empInfo['dID'] ) ) {
            $DesignationModel = DesignationModel::getInstance( );
            $dInfo = $DesignationModel->getInfo( );
            $key = array_search( $empInfo['dID'], array_column( $dInfo, 'id') );

            if( $empInfo['dID'] ) {
                $vars['dynamic']['designation'][] = array( 'TPLVAR_DESIGNATION' => $dInfo[$key]['title'] );
            }
        }

        if( $this->formWrapper == 'formWrapper' ) {
            $this->View->setJScript( array( 'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js',
                                            'input/handlebars.js', 'input/typeahead.bundle.min.js' ),
                                            'markaxis' => array( 'employeeForm.js', 'usuggest.js', 'competency.js' ) ) );
        }

        return $this->View->render( 'markaxis/employee/' . $this->formWrapper . '.tpl', $vars );
    }
}
?>