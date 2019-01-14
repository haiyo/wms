<?php
namespace Aurora\Component;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: SalaryTypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SalaryTypeModel extends \Model {


    // Properties


    /**
     * SalaryTypeModel Constructor
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
    public function isFound( $stID ) {
        File::import( DAO . 'Aurora/Component/SalaryType.class.php' );
        $SalaryType = new SalaryType( );
        return $SalaryType->isFound( $stID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        File::import( DAO . 'Aurora/Component/SalaryType.class.php' );
        $SalaryType = new SalaryType( );
        return $SalaryType->getList( );
    }
}
?>