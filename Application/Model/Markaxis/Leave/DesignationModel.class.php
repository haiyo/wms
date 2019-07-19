<?php
namespace Markaxis\Leave;
use \Aurora\Component\DesignationModel AS AuroraDesignation;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: DesignationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationModel extends \Model {


    // Properties
    protected $Designation;



    /**
     * DesignationModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Designation = new Designation( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->Designation->isFound( $ltID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByltID( $ltID ) {
        return $this->Designation->getByltID( $ltID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['designation'] ) && is_array( $data['designation'] ) ) {
            $DesignationModel = AuroraDesignation::getInstance( );
            $designation = $DesignationModel->getIDList( );

            foreach( $data['designation'] as $value ) {
                if( !isset( $designation[$value] ) ) {
                    return false;
                }
            }
            if( $this->isFound( $data['ltID'] ) ) {
                $this->Designation->delete('leave_designation', 'WHERE ltID = "' . (int)$data['ltID'] . '"');
            }
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];

            foreach( $data['designation'] as $value ) {
                $info['dID'] = $value;
                $this->Designation->insert( 'leave_designation', $info );
            }
        }
    }
}
?>