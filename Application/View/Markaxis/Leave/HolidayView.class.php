<?php
namespace Markaxis\Leave;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: HolidayView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HolidayView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $HolidayModel;


    /**
    * TypeView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->HolidayModel = HolidayModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( ) );

        $this->View->setJScript( array( 'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'picker.time.js' ),
                                        'plugins/moment' => 'moment.min.js',
                                        'markaxis' => array( 'pickerExtend.js', 'holiday.js' ) ) );

        return $this->View->render( 'markaxis/leave/holidayList.tpl', $vars );
    }
}
?>