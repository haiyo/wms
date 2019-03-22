<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: BankModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BankModel extends \Model {


    // Properties
    protected $Bank;


    /**
     * BankModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();

        $this->Bank = new Bank( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $bkID ) {
        return $this->Bank->isFound( $bkID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $bkID ) {
        return $this->Bank->getByID( $bkID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Bank->getList( );
    }
}
?>