<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Question.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Question extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $qID ) {
        $sql = $this->DB->select( 'SELECT COUNT(qID) FROM employee_question WHERE qID = "' . (int)$qID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM employee_question WHERE active <> "0"', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>