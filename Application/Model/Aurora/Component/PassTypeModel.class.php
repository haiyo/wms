<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PassTypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PassTypeModel extends \Model {


    // Properties
    protected $PassType;


    /**
     * PassTypeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->PassType = new PassType( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $id ) {
        return $this->PassType->isFound( $id );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->PassType->getList( );
    }
}
?>