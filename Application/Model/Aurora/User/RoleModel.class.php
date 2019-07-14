<?php
namespace Aurora\User;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: RoleModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RoleModel extends \Model {


    // Properties
    private $Role;


    /**
     * RoleModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct();
        $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->Role = new Role( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $roleID ) {
        return $this->Role->isFound( $roleID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByroleID( $oID ) {
        return $this->Role->getByroleID( $oID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        $Role = new Role();
        return $Role->getList( );
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $Validator = new Validator( );

        $this->info['roleID'] = (int)$data['roleID'];
        $this->info['title'] = Validator::stripTrim( $data['roleTitle'] );
        $this->info['descript'] = Validator::stripTrim( $data['roleDescript'] );

        $Validator->addModule( 'roleTitle', new IsEmpty( $this->info['title'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }
        return true;
    }


    /**
     * Save Pay Item information
     * @return int
     */
    public function save( ) {
        if( !$this->info['roleID'] ) {
            unset( $this->info['roleID'] );
            $this->info['roleID'] = $this->Role->insert( 'role', $this->info );
        }
        else {
            $this->Role->update( 'role', $this->info, 'WHERE roleID = "' . (int)$this->info['roleID'] . '"' );
        }
        return $this->info['roleID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $roleID ) {
        if( $this->isFound( $roleID ) ) {
            $info = array( );
            $info['deleted'] = 1;
            $this->Role->delete( 'role', 'WHERE roleID = "' . (int)$roleID . '"' );
        }
    }
}