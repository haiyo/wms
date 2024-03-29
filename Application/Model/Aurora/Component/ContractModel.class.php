<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ContractModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContractModel extends \Model {


    // Properties
    protected $Contract;


    /**
     * ContractModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');

        $this->Contract = new Contract( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        return $this->Contract->isFound( $cID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByID( $cID ) {
        return $this->Contract->getByID( $cID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getAll( ) {
        return $this->Contract->getAll( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Contract->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getIDList( ) {
        return $this->Contract->getIDList( );
    }


    /**
     * Return user data by userID
     * @return int
     */
    public function getListCount( $list ) {
        return $this->Contract->getListCount( $list );
    }
}
?>