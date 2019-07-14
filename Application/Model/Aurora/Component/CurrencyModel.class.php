<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CurrencyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CurrencyModel extends \Model {


    // Properties
    protected $Currency;


    /**
     * CurrencyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Currency = new Currency( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        return $this->Currency->isFound( $cID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Currency->getList( );
    }
}
?>