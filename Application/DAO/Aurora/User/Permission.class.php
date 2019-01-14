<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Permission.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Permission extends \DAO {


    // Properties
    protected $DB;

    
    /**
    * Permission Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Retrieve all permissons
    * @return mixed
    */
    public function getAll( ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT e.permID AS parentID, r.permID AS permID, r.title, r.descript
                                   FROM permission r
                                   LEFT JOIN permission e ON r.parent = e.permID
                                   ORDER BY COALESCE(parentID)',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>