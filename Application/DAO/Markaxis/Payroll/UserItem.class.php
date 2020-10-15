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
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByPuID( $puID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_user_item pui
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE pui.puID = "' . (int)$puID . '"
                                   ORDER BY puiID ASC',
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