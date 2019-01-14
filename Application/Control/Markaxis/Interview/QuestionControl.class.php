<?php
namespace Markaxis\Interview;
use \Library\IO\File;
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
    public function getMenu( $css ) {
        File::import( MODEL . 'Markaxis/Interview/QuestionModel.class.php' );
        $QuestionModel = QuestionModel::getInstance( );

        File::import( VIEW . 'Markaxis/Interview/QuestionView.class.php' );
        $QuestionView = new QuestionView( $QuestionModel );
        return $QuestionView->renderMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function view( ) {
        File::import( VIEW . 'Markaxis/Employee/QuestionView.class.php' );
        $QuestionView = new QuestionView( );
        echo $QuestionView->renderEdit( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        File::import( VIEW . 'Markaxis/Employee/QuestionView.class.php' );
        $QuestionView = new QuestionView( );
        Control::setOutputArrayAppend( array( 'form' => $QuestionView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        File::import( VIEW . 'Markaxis/Employee/QuestionView.class.php' );
        $QuestionView = new QuestionView( );
        Control::setOutputArrayAppend( array( 'form' => $QuestionView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function save( ) {
        File::import( MODEL . 'Markaxis/Employee/QuestionModel.class.php' );
        $QuestionModel = QuestionModel::getInstance( );
        $QuestionModel->save( Control::getPostData( ) );
    }
}
?>