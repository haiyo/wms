<?php
namespace Aurora\Component;
use \Library\IO\File;
use \Validator;
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
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ecID ) {
        File::import( DAO . 'Aurora/Component/Competency.class.php' );
        $Competency = new Competency( );
        return $Competency->isFound( $ecID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getIdByCompetency( $competency ) {
        File::import( DAO . 'Aurora/Component/Competency.class.php' );
        $Competency = new Competency( );
        return $Competency->getIdByCompetency( $competency );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        File::import( DAO . 'Aurora/Component/Competency.class.php' );
        $Competency = new Competency( );
        return $Competency->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getResults( $q ) {
        File::import( DAO . 'Aurora/Component/Competency.class.php' );
        $Competency = new Competency( );
        return $Competency->getResults( $q );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $competency ) {
        if( $competency ) {
            $competency = explode( ';', $competency );

            if( sizeof( $competency ) > 0 ) {
                File::import( LIB . 'Validator/Validator.dll.php' );
                File::import( DAO . 'Aurora/Component/Competency.class.php' );
                $Competency = new Competency( );
                $list = array( );

                foreach( $competency as $value ) {
                    $value = Validator::stripTrim( $value );

                    if( $value ) {
                        if( $info = $Competency->getIdByCompetency( $value ) ) {
                            array_push( $list, $info['cID'] );
                        }
                        else {
                            array_push( $list, $Competency->insert( 'competency', array( 'competency' => $value ) ) );
                        }
                    }
                }
                return $list;
            }
        }
    }
}
?>