<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LevyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LevyModel extends \Model {


    // Properties
    protected $Levy;


    /**
     * LevyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Levy = new Levy( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByPuID( $puID ) {
        return $this->Levy->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getChart( $data ) {
        return array( 'levies' => $this->Levy->getChart( $data['dateStart'], $data['totalRange'] ) );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getExistingLevies( $data ) {
        $levies = array( );

        if( isset( $data['payrollUser']['puID'] ) ) {
            $listLevies = $this->getByPuID( $data['payrollUser']['puID'] );

            if( sizeof( $listLevies ) > 0 ) {
                foreach( $listLevies as $levy ) {
                    $levies[] = array( 'title' => $levy['title'],
                                       'amount' => $levy['amount'] );
                }
            }
        }
        return $levies;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        $success = array( );

        if( isset( $data['puID'] ) && isset( $data['levies'] ) && sizeof( $data['levies'] ) ) {
            foreach( $data['levies'] as $levy ) {
                $info = array( );
                $info['puID'] = $data['puID'];
                $info['title'] = $levy['title'];
                $info['amount'] = $levy['amount'];
                array_push($success, $this->Levy->insert( 'payroll_levy', $info ) );
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->Levy->delete('payroll_levy', 'WHERE plID NOT IN(' . implode(',', $success ) . ') AND 
                                                       puID = "' . (int)$data['puID'] . '"');
        }
        else {
            $this->deletePayroll( $data );
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['puID'] ) ) {
            $this->Levy->delete('payroll_levy','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>