<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: DesignationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationModel extends \Model {


    // Properties
    protected $Designation;


    /**
     * DesignationModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Designation = new Designation( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $dID ) {
        return $this->Designation->isFound( $dID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByID( $dID ) {
        return $this->Designation->getByID( $dID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->info = $this->Designation->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getGroupList( ) {
        return $this->info = $this->Designation->getGroupList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getIDList( ) {
        return $this->info = $this->Designation->getIDList( );
    }


    /**
     * Return user data by userID
     * @return int
     */
    public function getListCount( $list ) {
        return $this->Designation->getListCount( $list );
    }
}
?>