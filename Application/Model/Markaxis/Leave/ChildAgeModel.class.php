<?php
namespace Markaxis\Leave;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ChildAgeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChildAgeModel extends \Model {


    // Properties
    protected $ChildAge;



    /**
     * ChildAgeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        File::import( DAO . 'Markaxis/Leave/ChildAge.class.php' );
        $this->ChildAge = new ChildAge( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->ChildAge->isFound( $ltID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByID( $ltID ) {
        return $this->ChildAge->getByID( $ltID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['childAge'] ) && $data['childAge'] > 0 ) {
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];
            $info['age'] = (int)$data['childAge'];

            if( $this->isFound( $data['ltID'] ) ) {
                $this->ChildAge->update('leave_child_age', $info, 'WHERE ltID = "' . (int)$data['ltID'] . '"');
            }
            else {
                $this->ChildAge->insert( 'leave_child_age', $info );
            }
        }
        else {
            $this->ChildAge->delete('leave_child_age','WHERE ltID = "' . (int)$data['ltID'] . '"');
        }
    }
}
?>