<?php
namespace Markaxis\Leave;
use \Aurora\Component\ContractModel AS AuroraContract;
use \Library\IO\File;

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
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        File::import( DAO . 'Markaxis/Leave/Contract.class.php' );
        $this->Contract = new Contract( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->Contract->isFound( $ltID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByID( $ltID ) {
        return $this->Contract->getByID( $ltID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['contractType'] ) && is_array( $data['contractType'] ) ) {
            File::import( MODEL . 'Aurora/Component/ContractModel.class.php' );
            $ContractModel = AuroraContract::getInstance( );
            $contract = $ContractModel->getIDList( );

            foreach( $data['contractType'] as $value ) {
                if( !isset( $contract[$value] ) ) {
                    return false;
                }
            }
            if( $this->isFound( $data['ltID'] ) ) {
                $this->Contract->delete('leave_contract', 'WHERE ltID = "' . (int)$data['ltID'] . '"');
            }
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];

            foreach( $data['contractType'] as $value ) {
                $info['cID'] = $value;
                $this->Contract->insert( 'leave_contract', $info );
            }
        }
    }
}
?>