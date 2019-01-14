<?php
namespace Markaxis\Employee;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CompetencyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyModel extends \Model {


    // Properties


    /**
     * CompetencyModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $cID ) {
        File::import( DAO . 'Markaxis/Employee/Competency.class.php' );
        $Competency = new Competency( );
        return $Competency->isFoundByUserID( $userID, $cID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID ) {
        File::import( DAO . 'Markaxis/Employee/Competency.class.php' );
        $Competency = new Competency( );
        return $Competency->getByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
        // Array with cID passthru from Component\CompetencyModel
        if( isset( $data['competency'] ) && is_array( $data['competency'] ) ) {

            File::import( DAO . 'Markaxis/Employee/Competency.class.php' );
            $Competency = new Competency( );

            foreach( $data['competency'] as $cID ) {
                if( !$this->isFoundByUserID( $data['userID'], $cID ) ) {
                    $info = array( );
                    $info['userID'] = (int)$data['userID'];
                    $info['eID'] = (int)$data['eID'];
                    $info['cID'] = (int)$cID;
                    $Competency->insert( 'employee_competency', $info );
                }
            }
            $competency = implode( ',', $data['competency'] );

            if( $competency )
                $Competency->delete( 'employee_competency', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                        cID NOT IN(' . addslashes( $competency ) . ')' );
        }
    }
}
?>