<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: StateModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StateModel extends \Model {


    // Properties
    protected $State;


    /**
     * StateModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->State = new State( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $sID ) {
        return $this->State->isFound( $sID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( $data ) {
        if( isset( $data['country'] ) ) {
            return $this->State->getList( $data['country'] );
        }
        return false;
    }
}
?>