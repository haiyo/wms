<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollLevy.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollLevy extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByPuID( $puID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_levy
                                   WHERE puID = "' . (int)$puID . '"',
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