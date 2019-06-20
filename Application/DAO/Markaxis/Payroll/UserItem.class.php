<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserItem.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserItem extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function getUserItem( $userID, $piID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_user_item pui
                                   WHERE pui.userID = "' . (int)$userID . '" AND 
                                         pui.piID = "' . (int)$piID . '"',
                                   __FILE__, __LINE__ );

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