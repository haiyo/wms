<?php
namespace Markaxis\Interview;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: QuestionModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class QuestionModel extends \Model {


    // Properties



    /**
     * QuestionModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $qsID ) {
        $Question = new Question( );
        return $Question->isFound( $qsID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getList( ) {
        $Question = new Question( );
        return $Question->getList( );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        //
    }
}
?>