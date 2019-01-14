<?php
namespace Markaxis\Leave;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: StructureModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StructureModel extends \Model {


    // Properties
    protected $Structure;


    /**
     * StructureModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        File::import( DAO . 'Markaxis/Leave/Structure.class.php' );
        $this->Structure = new Structure( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->Structure->isFound( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $ltID ) {
        return $this->Structure->getByID( $ltID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        $preg = '/^start_(\d)+/';

        $callback = function( $val ) use( $preg ) {
            if( preg_match( $preg, $val, $match ) ) {
                return $match;
            } else {
                return false;
            }
        };

        $structure = array_filter( $data, $callback, ARRAY_FILTER_USE_KEY );
        $sizeof = sizeof( $structure );
        $validIDs = array(0);

        if( $sizeof > 0 ) {
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];

            foreach( $structure as $key => $value ) {
                preg_match( $preg, $key, $match );

                if( isset( $match[1] ) && is_numeric( $match[1] ) ) {
                    $id = $match[1];

                    $info['start'] = (int)$data['start_' . $id];
                    $info['end'] = (int)$data['end_' . $id];
                    $info['days'] = (int)$data['days_' . $id];

                    if( !$data['lsID_' . $id] ) {
                        array_push( $validIDs, $this->Structure->insert( 'leave_structure', $info ) );
                    }
                    else if( $this->isFoundByID( $data['ltID'], $data['lsID_' . $id] ) ) {
                        $this->Structure->update( 'leave_structure', $info,
                                                 'WHERE ltID = "' . (int)$data['ltID'] . '" AND 
                                                               lsID = "' . (int)$data['lsID_' . $id] . '"' );

                        array_push($validIDs, $data['lsID_' . $id] );
                    }
                }
            }
            $validIDs = implode(',', $validIDs );
            $this->Structure->delete('leave_structure', 'WHERE ltID = "' . (int)$data['ltID'] . '" AND 
                                                            lsID NOT IN(' . addslashes( $validIDs ) . ')');
        }
    }
}
?>