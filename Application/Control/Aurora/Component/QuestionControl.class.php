<?php
namespace Aurora\Component;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: QuestionControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class QuestionControl {


    // Properties


    /**
     * QuestionControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function view( ) {
        $QuestionView = new QuestionView( );
        echo $QuestionView->renderEdit( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        $QuestionView = new QuestionView( );
        Control::setOutputArrayAppend( array( 'form' => $QuestionView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        $QuestionView = new QuestionView( );
        Control::setOutputArrayAppend( array( 'form' => $QuestionView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function save( ) {
        $QuestionModel = QuestionModel::getInstance( );
        $QuestionModel->save( Control::getPostData( ) );
    }
}
?>