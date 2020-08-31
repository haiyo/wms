<?php
namespace Aurora\Admin;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Cron.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Cron extends \DAO {


    // Properties



    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getAll( ) {
        $sql = $this->DB->select( 'SELECT * FROM cron WHERE disabled = "0"', __FILE__, __LINE__ );

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