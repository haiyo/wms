<?php
namespace Aurora;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AdditionalView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class QuestionView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $QuestionModel;
    protected $info;


    /**
    * QuestionView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/EmployeeRes');
        $this->YesNoRes = $this->i18n->loadLanguage('Aurora/Helper/YesNoRes');

        $this->QuestionModel = QuestionModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAdd( ) {
        $this->info = $this->QuestionModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $userID ) {
        if( $this->info = $this->QuestionModel->getFieldByUserID( $userID, '*' ) ) {
            return $this->renderForm( );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( ) {
        $questions = $this->QuestionModel->getList( );
        $count = 1;

        $vars['dynamic']['col1'] = false;
        $vars['dynamic']['col2'] = false;

        foreach( $questions as $key => $value ) {
            if( $count++ % 2 == 0 ) {
                $vars['dynamic']['col2'][] = array_merge( $this->YesNoRes->getContents( ),
                                             array( 'TPLVAR_QS_ID' => $value['qID'],
                                                    'TPLVAR_QUESTION' => $value['question'],
                                                    'TPLVAR_YES' => $value['yes'],
                                                    'TPLVAR_NO' => $value['no'],
                                                    'TPLVAR_HIDE_RADIO' => ( $value['yes'] || $value['no'] ) ? '' : 'hide',
                                                    'TPLVAR_NEED_INFO' => $value['info'] ? 'needInfo' : '' ) );
            }
            else {
                $vars['dynamic']['col1'][] = array_merge( $this->YesNoRes->getContents( ),
                                             array( 'TPLVAR_QS_ID' => $value['qID'],
                                                    'TPLVAR_QUESTION' => $value['question'],
                                                    'TPLVAR_YES' => $value['yes'],
                                                    'TPLVAR_NO' => $value['no'],
                                                    'TPLVAR_HIDE_RADIO' => ( $value['yes'] || $value['no'] ) ? '' : 'hide',
                                                    'TPLVAR_NEED_INFO' => $value['info'] ? 'needInfo' : '' ) );
            }
        }
        return $this->render( 'markaxis/employee/questionForm.tpl', $vars );
    }
}
?>