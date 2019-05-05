<?php
namespace Markaxis\Expense;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ClaimControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ClaimControl {


    // Properties
    protected $ClaimModel;
    protected $ClaimView;


    /**
     * ClaimControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ClaimModel = ClaimModel::getInstance( );
        $this->ClaimView = new ClaimView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function claim( ) {
        $this->ClaimView->printAll( $this->ClaimView->renderClaimList( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getClaimResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->ClaimModel->getResults( $post ) );
        exit;
    }
}
?>