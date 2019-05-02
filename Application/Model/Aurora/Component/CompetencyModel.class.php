<?php
namespace Aurora\Component;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CompetencyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyModel extends \Model {


    // Properties
    protected $Competency;


    /**
     * CompetencyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Competency = new Competency( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        return $this->Competency->isFound( $cID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getIdByCompetency( $competency ) {
        return $this->Competency->getIdByCompetency( $competency );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Competency->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getResults( $q ) {
        return $this->Competency->getResults( $q );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $competency ) {
        if( $competency ) {
            $competency = explode( ';', $competency );

            if( sizeof( $competency ) > 0 ) {
                $list = array( );

                foreach( $competency as $value ) {
                    $value = Validator::stripTrim( $value );

                    if( $value ) {
                        if( $info = $this->Competency->getIdByCompetency( $value ) ) {
                            array_push( $list, $info['cID'] );
                        }
                        else {
                            array_push( $list, $this->Competency->insert( 'competency', array( 'competency' => $value ) ) );
                        }
                    }
                }
                return $list;
            }
        }
    }
}
?>