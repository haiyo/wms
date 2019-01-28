<?php
namespace Aurora\Chat;
use \Aurora\Admin\AdminView;
use \Aurora\User\UserModel;
use \Library\Runtime\Registry, \Library\Util\MXString;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: MessageView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MessageView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $MessageModel;


    /**
    * MessageView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/AdditionalRes');

        $this->MessageModel = MessageModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderMessage( $data ) {
        $userInfo = UserModel::getInstance( )->getInfo( );
        $messageInfo = $this->MessageModel->getInfo( );
        $MXString = new MXString( );

        $time = strtotime( $messageInfo['created'] );

        $vars = array( 'TPLVAR_FNAME' => $userInfo['fname'],
                       'TPLVAR_LNAME' => $userInfo['lname'],
                       'TPLVAR_TIME' => date( 'g:i A', $time ),
                       'TPLVAR_DATE_TIME' => $messageInfo['created'],
                       'TPLVAR_MESSAGE' => $MXString->makeLink( $messageInfo['message'] ) );

        return $this->render( 'aurora/chat/message.tpl', $vars );
    }
}
?>