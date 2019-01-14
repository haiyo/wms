<?php
namespace Aurora\Component;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: StateModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StateModel extends \Model {


    // Properties


    /**
     * StateModel Constructor
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
    public function isFound( $sID ) {
        File::import( DAO . 'Aurora/Component/State.class.php' );
        $State = new State( );
        return $State->isFound( $sID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( $data ) {
        if( isset( $data['country'] ) ) {
            File::import(DAO . 'Aurora/Component/State.class.php');
            $State = new State();
            return $State->getList( $data['country'] );
        }
        return false;
    }
}
?>