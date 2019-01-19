<?php
namespace Markaxis\Leave;
use \Aurora\Component\OfficeModel AS AuroraOffice;

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
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Office = new Office( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->Office->isFound( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getOffice( $ltID, $oID ) {
        return $this->Office->getOffice( $ltID, $oID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['office'] ) && is_array( $data['office'] ) ) {
            $OfficeModel = AuroraOffice::getInstance( );
            $office = $OfficeModel->getList( );

            foreach( $data['office'] as $value ) {
                if( !isset( $office[$value] ) ) {
                    return false;
                }
            }
            if( $this->isFound( $data['ltID'] ) ) {
                $this->Office->delete('leave_office', 'WHERE ltID = "' . (int)$data['ltID'] . '"');
            }
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];

            foreach( $data['office'] as $value ) {
                $info['oID'] = (int)$value;
                $this->Office->insert( 'leave_office', $info );
            }
        }
    }
}
?>