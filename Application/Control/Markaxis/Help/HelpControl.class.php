<?php
namespace Markaxis;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: HelpControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HelpControl {


    // Properties
    protected $HelpModel;
    protected $HelpView;


    /**
     * HelpControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->HelpModel = HelpModel::getInstance( );
        $this->HelpView = new HelpView( $this->HelpModel );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getMenu( $css ) {
        return $this->HelpView->renderMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getGuideMenu( $css ) {
        return $this->HelpView->renderGuideMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getFAQMenu( $css ) {
        return $this->HelpView->renderFAQMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getContactMenu( $css ) {
        return $this->HelpView->renderContactMenu( $css );
    }

}
?>