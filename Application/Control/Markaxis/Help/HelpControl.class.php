<?php
namespace Markaxis;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: HelpControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HelpControl {


    // Properties


    /**
     * HelpControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getMenu( $css ) {
        File::import( MODEL . 'Markaxis/Help/HelpModel.class.php' );
        $HelpModel = HelpModel::getInstance( );

        File::import( VIEW . 'Markaxis/Help/HelpView.class.php' );
        $HelpView = new HelpView( $HelpModel );
        return $HelpView->renderMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getGuideMenu( $css ) {
        File::import( MODEL . 'Markaxis/Help/HelpModel.class.php' );
        $HelpModel = HelpModel::getInstance( );

        File::import( VIEW . 'Markaxis/Help/HelpView.class.php' );
        $HelpView = new HelpView( $HelpModel );
        return $HelpView->renderGuideMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getFAQMenu( $css ) {
        File::import( MODEL . 'Markaxis/Help/HelpModel.class.php' );
        $HelpModel = HelpModel::getInstance( );

        File::import( VIEW . 'Markaxis/Help/HelpView.class.php' );
        $HelpView = new HelpView( $HelpModel );
        return $HelpView->renderFAQMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getContactMenu( $css ) {
        File::import( MODEL . 'Markaxis/Help/HelpModel.class.php' );
        $HelpModel = HelpModel::getInstance( );

        File::import( VIEW . 'Markaxis/Help/HelpView.class.php' );
        $HelpView = new HelpView( $HelpModel );
        return $HelpView->renderContactMenu( $css );
    }

}
?>