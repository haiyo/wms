<?php
namespace Aurora\Component;
use \Library\IO\File;
use \Aurora\Component\CountryModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: OfficeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeModel extends \Model {


    // Properties
    protected $Office;


    /**
     * OfficeModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');

        File::import( DAO . 'Aurora/Component/Office.class.php' );
        $this->Office = new Office( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $eoID ) {
        return $this->Office->isFound( $eoID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByOID( $oID ) {
        return $this->Office->getByOID( $oID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        $list = $this->Office->getList( );
        $newList = array( );

        File::import( MODEL . 'Aurora/Component/CountryModel.class.php' );
        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );

        if( sizeof( $list ) > 0 ) {
            foreach( $list as $key => $value ) {
                $newList[$key] = $value['name'] . ' (' .  $countries[$value['cID']] . ')';
            }
        }
        return $newList;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getIDList( ) {
        return $this->Office->getIDList( );
    }
}
?>