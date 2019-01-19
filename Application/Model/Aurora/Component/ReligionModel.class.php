<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ReligionModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ReligionModel extends \Model {


    // Properties
    protected $Religion;


    /**
     * ReligionModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Religion = new Religion( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $id ) {
        return $this->Religion->isFound( $id );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Religion->getList( );
    }
}
?>