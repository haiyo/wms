<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: RaceModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RaceModel extends \Model {


    // Properties
    protected $Race;


    /**
     * RaceModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Race = new Race( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $id ) {
        return $this->Race->isFound( $id );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Race->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getListCount( $list ) {
        return $this->Race->getListCount( $list );
    }
}
?>