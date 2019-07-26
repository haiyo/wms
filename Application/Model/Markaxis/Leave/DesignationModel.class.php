<?php
namespace Markaxis\Leave;
use \Aurora\Component\DesignationModel AS A_Designation;

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
    public function getBylgID( $lgID ) {
        return $this->Designation->getBylgID( $lgID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['leaveGroups'] ) && is_array( $data['leaveGroups'] ) ) {
            $DesignationModel = A_Designation::getInstance( );

            foreach( $data['leaveGroups'] as $groupObj ) {
                if( isset( $groupObj->designations ) && is_array( $groupObj->designations ) ) {
                    foreach( $groupObj->designations as $designation ) {
                        if( $DesignationModel->isFound( $designation ) ) {
                            // Group is not unset here, so its safe
                            $this->Designation->delete('leave_designation', 'WHERE lgID = "' . (int)$data['lgID'] . '"');

                            $info = array( );
                            $info['lgID'] = $data['lgID'];
                            $info['dID'] = $designation;
                            $this->Designation->insert( 'leave_designation', $info );

                        }
                    }

                }
            }
        }
    }
}
?>