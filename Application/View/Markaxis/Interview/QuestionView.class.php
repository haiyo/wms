<?php
namespace Markaxis\Interview;
use \Aurora\AuroraView;
use \Library\IO\File;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: QuestionView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class QuestionView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $QuestionsModel;


    /**
    * QuestionView Constructor
    * @return void
    */
    function __construct( QuestionModel $QuestionModel ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Interview/QuestionsRes');
        $this->QuestionModel = $QuestionModel;
    }


    /**
    * Render main navigation
    * @return str
    */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_ALUMNI_MANAGEMENT') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAdd( ) {
        $this->info = $this->QuestionModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderEdit( $userID ) {
        if( $this->info = $this->QuestionModel->getFieldByUserID( $userID, '*' ) ) {
            return $this->renderForm( );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderForm( ) {
        File::import( MODEL . 'Aurora/Component/QuestionModel.class.php' );
        $QuestionModel = \Aurora\QuestionModel::getInstance( );
        $questions = $QuestionModel->getList( );
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