<?php
namespace Aurora\Page;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $L10n;
    protected $View;
    protected $PageModel;


    /**
    * PageView Constructor
    * @return void
    */
    function __construct( PageModel $PageModel ) {
        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $this->View = AuroraView::getInstance( );
        $this->PageModel = $PageModel;

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/PageRes');

        $this->View->setJScript( array( 'jquery.ui.draggable'  => 'jquery/jquery.ui.draggable.js',
                                        'jquery.ui.droppable'  => 'jquery/jquery.ui.droppable.js',
                                        'jquery.ui.lightbox'   => 'jquery/jquery.ui.lightbox.js',
                                        'aurora.page'          => 'aurora/aurora.page.js',
                                        'aurora.droplet'       => 'aurora/aurora.droplet.js',
                                        'aurora.page.i18n'     => 'locale/' . $this->L10n->getL10n( ) ) );

        $this->View->setStyle( array( 'aurora/core' => 'aurora',
                                      'aurora/page' => 'page',
                                      'aurora/droplet' => 'droplet',
                                      'jquery' => 'lightbox' ) );
	}


    /**
    * Page Setup
    * @return mixed
    */
    public function renderPage( $args ) {
        $args = isset( $args[0] ) ? $args[0] : 1;
        $pageInfo = $this->PageModel->getPageInfo( $args );

        //$Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        //$userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        /*$MessageModel = MessageModel::getInstance( );
        $pmCount = $MessageModel->getCountCache( );
        $title   = $pmCount ? '(' . $pmCount . ') ' : '';
        $title  .= $this->HKEY_LOCAL['websiteName'] . ': ' . $pageInfo['pageTitle'];*/
        $title = $pageInfo['pageTitle'];

        $this->View->setTitle( $title );
        $primary = $secondary = $tertiary = $quaternary = '';
        $droplets = explode( '|', $pageInfo['droplets'] );
        $dropletCount = sizeof( $droplets );

        if( $dropletCount > 0 ) {
            $DropletModel = new DropletModel( );
            $DropletView = new DropletView( $DropletModel );

            for( $i=0; $i<$dropletCount; $i++ ) {
                $dropletIDs = explode( ',', $droplets[$i] );
                $sizeof = sizeof( $dropletIDs );

                for( $j=0; $j<$sizeof; $j++ ) {
                    if( $dropletIDs[$j] == '' ) {
                        continue;
                    }
                    //$dropletID = preg_replace( '/^[0-9]$/', '', $dropletIDs[$j] );
                    //echo $dropletID . '<br />';
                    // Make use of (int) in DAO to force cast! For e.g: 9_14_0 casting to (int) 9
                    $droplet = $DropletModel->getDropletByID( $dropletIDs[$j] );

                    if( $droplet ) {
                        $this->View->setJScript( array( $droplet['script'] => strtolower( $droplet['namespace'] ) . '/' . $droplet['dropletDir'] . '/' . $droplet['script'] ) );

                        if( $i == 0 ) {
                            $primary .= $DropletView->renderDropletContainer( $dropletIDs[$j], $droplet );
                        }
                        if( $i == 1 ) {
                            $secondary .= $DropletView->renderDropletContainer( $dropletIDs[$j], $droplet );
                        }
                        if( $i == 2 ) {
                            $tertiary .= $DropletView->renderDropletContainer( $dropletIDs[$j], $droplet );
                        }
                        if( $i == 3 ) {
                            $quaternary .= $DropletView->renderDropletContainer( $dropletIDs[$j], $droplet );
                        }
                    }
                }
            }
        }
        $primaryNoDroplets    = $primary    != '' ? ' style="display:none;"' : '';
        $secondaryNoDroplets  = $secondary  != '' ? ' style="display:none;"' : '';
        $tertiaryNoDroplets   = $tertiary   != '' ? ' style="display:none;"' : '';
        $quaternaryNoDroplets = $quaternary != '' ? ' style="display:none;"' : '';

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_PRIMARY_DROPLETS'       => $primary,
                       'TPLVAR_SECONDARY_DROPLETS'     => $secondary,
                       'TPLVAR_TERTIARY_DROPLETS'      => $tertiary,
                       'TPLVAR_QUATERNARY_DROPLETS'    => $quaternary,
                       'TPLVAR_PRIMARY_NO_DROPLETS'    => $primaryNoDroplets,
                       'TPLVAR_SECONDARY_NO_DROPLETS'  => $secondaryNoDroplets,
                       'TPLVAR_TERTIARY_NO_DROPLETS'   => $tertiaryNoDroplets,
                       'TPLVAR_QUATERNARY_NO_DROPLETS' => $quaternaryNoDroplets ) );

        return $this->View->render( 'aurora/page/html/' . $pageInfo['layout'] . '.tpl', $vars );
    }
}
?>