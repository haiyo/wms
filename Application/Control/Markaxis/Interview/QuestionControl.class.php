<?php
namespace Markaxis\Interview;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: QuestionControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class QuestionControl {


    // Properties
    protected $QuestionModel;
    protected $QuestionView;


    /**
     * QuestionControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->QuestionModel = QuestionModel::getInstance( );
        $this->QuestionView = new QuestionView( $this->QuestionModel );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getMenu( $css ) {
        return $this->QuestionView->renderMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function view( ) {
        echo $this->QuestionView->renderEdit( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->QuestionView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        Control::setOutputArrayAppend( array( 'form' => $this->QuestionView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function save( ) {
        $this->QuestionModel->save( Control::getPostData( ) );
    }
}
?>