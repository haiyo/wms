<?php
namespace Aurora\Component;
use \Library\IO\File;
use \Validator;
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

        $this->info['resume'] = $this->info['recruitSourceID'] = $this->info['eName1'] =
        $this->info['eRelationship1'] = $this->info['eHome1'] = $this->info['eMobile1'] =
        $this->info['ename2'] = $this->info['eRelationship2'] = $this->info['eHome2'] =
        $this->info['eMobile2'] = $this->info['notes'] = '';
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $qsID ) {
        File::import( DAO . 'Aurora/Component/Question.class.php' );
        $Question = new Question( );
        return $Question->isFound( $qsID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getList( ) {
        File::import( DAO . 'Aurora/Component/Question.class.php' );
        $Question = new Question( );
        return $Question->getList( );
    }
}
?>