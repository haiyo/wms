<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Tax.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Tax extends \DAO {


    // Properties


    /**
     * Tax Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID ) {
        $sql = $this->DB->select( 'SELECT COUNT(trID) FROM tax_rule WHERE trID = "' . (int)$trID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByGroupID( $tgID ) {
        $sql = $this->DB->select( 'SELECT COUNT(tgID) FROM tax_group WHERE tgID = "' . (int)$tgID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getParentList( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT tgID, title FROM tax_group WHERE parent = 0',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['tgID']] = $row['title'];
            }
        }
        return $list;
    }
}
?>