<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: DepartmentModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentModel extends \Model {


    // Properties
    protected $Department;


    /**
     * DepartmentModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Department = new Department( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $dID ) {
        return $this->Department->isFound( $dID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByID( $dID ) {
        return $this->Department->getByID( $dID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Department->getList( );
    }
}
?>