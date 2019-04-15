<?php
namespace Aurora\Page;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NotFoundView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NotFoundView extends AdminView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $L10n;
    protected $View;
    protected $NotFoundModel;


    /**
     * NotFoundView Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get(HKEY_LOCAL);
        $this->NotFoundModel = NotFoundModel::getInstance( );;

        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $i18n->loadLanguage('Aurora/Page/NotFoundRes');

        $this->setJScript( array( 'pages' => 'dashboard.js',
                                  'plugins' => array( 'forms/styling/switchery.min.js', 'moment/moment.min.js',
                                                      'pickers/daterangepicker.js' ),
                                  'plugins/visualization' => array( 'd3/d3.min.js', 'd3/d3_tooltip.js' ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderPage( ) {
        $this->setBreadcrumbs( array( 'link' => '', 'text' => $this->L10n->getContents('LANG_404_NOT_FOUND') ) );
        return $this->render( 'aurora/page/notFound.tpl', array_merge( $this->L10n->getContents( ), array( ) ) );
    }
}
?>