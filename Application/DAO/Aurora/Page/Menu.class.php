<?php
namespace Aurora\Page;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Page.class.php, v 2.0 Exp $
 */

class Menu extends \DAO {

    // Properties
    

    /**
    * Page Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
    }
    
    
    /**
    * Return a menu tree
    * @return mixed
    */
    public function getMenu( ) {
        $menu = array( );
        $sql = $this->DB->select( 'SELECT * FROM menu WHERE parent = "0" AND active = "1"
                                   ORDER BY sorting ASC',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $sql2 = $this->DB->select( 'SELECT * FROM menu WHERE parent = "' . (int)$row['id'] . '"
                                                                      AND active = "1"
                                            ORDER BY sorting ASC',
                                            __FILE__, __LINE__ );

                if( $this->DB->numrows( $sql2 ) > 0 ) {
                    while( $sub = $this->DB->fetch( $sql2 ) ) {
                        $row['child'][] = $sub;
                    }
                }
                $menu[] = $row;
            }
        }
        return $menu;
    }
}
?>