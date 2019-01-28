<?php
namespace Markaxis\Attendance;
use \Aurora\Admin\AdminView;
use  \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AttendanceView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AttendanceView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $AttendanceModel;


    /**
    * AttendanceView Constructor
    * @return void
    */
    function __construct( AttendanceModel $AttendanceModel ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Attendance/AttendanceRes');
        $this->AttendanceModel = $AttendanceModel;
    }


    /**
    * Render main navigation
    * @return str
    */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_ATTENDANCE_MANAGEMENT') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }
}
?>