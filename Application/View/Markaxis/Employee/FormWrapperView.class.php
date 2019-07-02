<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView, \Aurora\User\UserModel;
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
                                        'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js',
                                                                  'input/handlebars.js', 'input/typeahead.bundle.min.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'plugins/uploaders' => array( 'fileinput.min.js', 'croppie.min.js', 'exif.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ),
                                        'markaxis' => array( 'employee.js', 'uSuggest.js', 'competency.js' ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAdd( $form ) {
        $this->View->setBreadcrumbs( array( 'link' => 'admin/employee/add',
                                            'icon' => 'icon-user-plus',
                                            'text' => $this->L10n->getContents('LANG_ADD_NEW_EMPLOYEE') ) );
        $this->View->printAll( $this->renderForm( $form ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $form, $userID, $photo ) {
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-user-plus',
                                            'text' => $this->L10n->getContents('LANG_EDIT_EMPLOYEE_INFO') ) );

        $this->View->printAll( $this->renderForm( $form, $userID, $photo ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( $form, $userID=0, $photo='' ) {
        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        $vars = array( 'TPLVAR_USERID' => $userID,
                       'TPLVAR_THUMBNAIL' => rand(1, 8),
                       'TPLVAR_DEF_PHOTO' => '',
                       'TPL_FORM' => $form );

        if( $userInfo['fname'] ) {
            $vars['dynamic']['name'][] = array( 'TPLVAR_FNAME' => $userInfo['fname'],
                                                'TPLVAR_LNAME' => $userInfo['lname'] );
        }
        else {
            $vars['dynamic']['name'] = false;
        }

        if( $userInfo['email1'] ) {
            $vars['dynamic']['email'][] = array( 'TPLVAR_EMAIL' => $userInfo['email1'] );
        }
        else {
            $vars['dynamic']['email'] = false;
        }

        if( $photo ) {
            $vars['TPLVAR_DEF_PHOTO'] = 'hide';
            $vars['dynamic']['photo'][] = array( 'TPLVAR_PHOTO' => $photo );
        }
        else {
            $vars['dynamic']['photo'] = false;
        }

        if( $userInfo['phone'] ) {
            $vars['dynamic']['phone'][] = array( 'TPLVAR_PHONE' => $userInfo['phone'] );
        }
        else {
            $vars['dynamic']['phone'] = false;
        }

        if( $userInfo['mobile'] ) {
            $vars['dynamic']['mobile'][] = array( 'TPLVAR_MOBILE' => $userInfo['mobile'] );
        }
        else {
            $vars['dynamic']['mobile'] = false;
        }

        $EmployeeModel = EmployeeModel::getInstance( );
        $eInfo = $EmployeeModel->getInfo( );

        $vars['dynamic']['designation'] = false;

        if( isset( $eInfo['dID'] ) ) {
            $DesignationModel = DesignationModel::getInstance( );
            $dInfo = $DesignationModel->getInfo( );
            $key = array_search( $eInfo['dID'], array_column( $dInfo, 'id') );

            if( $eInfo['dID'] ) {
                $vars['dynamic']['designation'][] = array( 'TPLVAR_DESIGNATION' => $dInfo[$key]['title'] );
            }
        }
        return $this->View->render( 'markaxis/employee/formWrapper.tpl', $vars );
    }
}
?>