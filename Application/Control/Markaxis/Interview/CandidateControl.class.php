<?php
namespace Markaxis\Interview;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CandidateControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CandidateControl {


    // Properties


    /**
     * CandidateControl Constructor
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
        $CandidateModel = CandidateModel::getInstance( );
        $CandidateView = new CandidateView( $CandidateModel );
        return $CandidateView->renderMenu( $css );
    }
}
?>