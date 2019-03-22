<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PaymentMethodModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PaymentMethodModel extends \Model {


    // Properties
    protected $PaymentMethod;


    /**
     * PaymentMethodModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();

        $this->PaymentMethod = new PaymentMethod( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $pmID ) {
        return $this->PaymentMethod->isFound( $pmID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByID( $pmID ) {
        return $this->PaymentMethod->getByID( $pmID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->PaymentMethod->getList( );
    }
}
?>