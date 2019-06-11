<?php
namespace Aurora\Page;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Menu.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Menu extends \DAO {


    // Properties
    
    
    /**
    * Return a menu tree
    * @return mixed
    */
    public function getMenu( ) {
        $sql = $this->DB->select( 'SELECT m.mID AS parentID, child.mID AS id, child.*, 
                                          GROUP_CONCAT( IFNULL( CONCAT( p.namespace, ".", p.action ) , "" ) ) AS perms
                                   FROM menu child
                                   LEFT JOIN menu m ON ( child.parent = m.mID )
                                   LEFT JOIN menu_perm mp ON ( mp.mID = child.mID )
                                   LEFT JOIN permission p ON ( p.pID = mp.pID )
                                   GROUP BY child.mID
                                   ORDER BY COALESCE(child.parent, child.mID), child.sorting',
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