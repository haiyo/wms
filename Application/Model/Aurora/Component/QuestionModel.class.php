<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: QuestionModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class QuestionModel extends \Model {


    // Properties
    protected $Question;


    /**
     * QuestionModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->info['resume'] = $this->info['recruitSourceID'] = $this->info['eName1'] =
        $this->info['eRelationship1'] = $this->info['eHome1'] = $this->info['eMobile1'] =
        $this->info['ename2'] = $this->info['eRelationship2'] = $this->info['eHome2'] =
        $this->info['eMobile2'] = $this->info['notes'] = '';

        $this->Question = new Question( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $qsID ) {
        return $this->Question->isFound( $qsID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getList( ) {
        return $this->Question->getList( );
    }
}
?>