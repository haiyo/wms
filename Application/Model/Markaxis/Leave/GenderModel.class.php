<?php
namespace Markaxis\Leave;
use \Library\Helper\Aurora\GenderHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: GenderModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GenderModel extends \Model {


    // Properties
    protected $Gender;



    /**
     * GenderModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Gender = new Gender( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->Gender->isFound( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $ltID ) {
        return $this->Gender->getByID( $ltID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['gender'] ) && is_array( $data['gender'] ) ) {
            foreach( $data['gender'] as $value ) {
                if( !isset( GenderHelper::getL10nList( )[$value] ) ) {
                    return false;
                }
            }
            if( $this->isFound( $data['ltID'] ) ) {
                $this->Gender->delete('leave_gender', 'WHERE ltID = "' . (int)$data['ltID'] . '"');
            }
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];

            foreach( $data['gender'] as $value ) {
                $info['gender'] = $value;
                $this->Gender->insert( 'leave_gender', $info );
            }
        }
    }
}
?>