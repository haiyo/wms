<?php
namespace Markaxis\Leave;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Office.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Office extends DAO {


    // Properties


    /**
     * Office Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        $sql = $this->DB->select( 'SELECT COUNT(loID) FROM leave_office
                                   WHERE ltID = "' . (int)$ltID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getOffice( $ltID, $oID ) {
        $sql = $this->DB->select( 'SELECT * FROM leave_office lo 
                                   LEFT JOIN office o ON (o.oID = lo.oID)
                                   WHERE lo.ltID = "' . (int)$ltID . '" AND
                                         lo.oID = "' . (int)$oID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>