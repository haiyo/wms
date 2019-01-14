<?php
namespace Aurora\Component;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: BankModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BankModel extends \Model {


    // Properties


    /**
     * BankModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $bkID ) {
        File::import( DAO . 'Aurora/Component/Bank.class.php' );
        $Bank = new Bank( );
        return $Bank->isFound( $bkID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        File::import( DAO . 'Aurora/Component/Bank.class.php' );
        $Bank = new Bank( );
        return $Bank->getList( );
    }
}
?>