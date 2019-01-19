<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxModel extends \Model {


    // Properties
    protected $Tax;



    /**
     * BankModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->info['pcID'] = '';
        $this->Tax = new Tax( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->Tax->isFoundByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->Tax->getByUserID( $userID, $column );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getListByUserID( $userID ) {
        return $this->info = $this->Tax->getListByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function existByTGIDs( $tgIDs ) {
        return (int)$this->Tax->existByTGIDs( $tgIDs );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['tgID'] ) && is_array( $data['tgID'] ) ) {
            // Make sure all tgIDs are valid
            if( $this->existByTGIDs( $data['tgID'] ) ) {
                $this->Tax->delete('employee_tax', 'WHERE userID = "' . (int)$data['userID'] . '"');

                $saveInfo = array( );
                $saveInfo['userID'] = (int)$data['userID'];

                foreach( $data['tgID'] as $value ) {
                    $saveInfo['tgID'] = (int)$value;
                    $this->Tax->insert( 'employee_tax', $saveInfo );
                }
            }
        }
        // If no tgID is pass in, delete any existing data
        else if( $this->Tax->isFoundByUserID( $data['userID'] ) ) {
            $this->Tax->delete('employee_tax', 'WHERE userID = "' . (int)$data['userID'] . '"');
        }
    }
}
?>