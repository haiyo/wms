<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RoleListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RoleListView extends MultiListView {


    // Properties
    private $cropTextChar = false;


    /**
    * RoleListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}
    
    
    /**
    * Crop Text
    * @return void
    */
    public function setCropText( $length ) {
        $this->cropTextChar = (int)$length;
    }


    /**
    * Return Role List
    * @return str
    */
    public function getList( $roleList='', $withAdmin=false, $withHeader=false, $id='roles', $extras=array( ) ) {
        $Role = new Role( );
        $roles = $Role->getRoleList( );
        if( !$withAdmin ) unset( $roles[1] ); // Perhaps to be in the model...
        if( $withHeader  ) {
            $roles[0] = $withHeader;
        }
        if( sizeof( $extras ) > 0 ) {
            foreach( $extras as $key => $value ) {
                $roles[$key] = $value;
            }
        }
        if( $this->cropTextChar ) {
            array_walk_recursive( $roles, array( $this, 'recurCrop' ) );
        }
        ksort( $roles );
        return $this->build( $id, $roles, $roleList );
    }
    
    
    /**
    * Crop values recursively from an array
    * @return void
    */
    private function recurCrop( &$value ) {
        $value = String::cropText( $value, $this->cropTextChar );
    }
}
?>