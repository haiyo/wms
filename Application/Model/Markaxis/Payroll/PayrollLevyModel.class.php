<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollLevyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollLevyModel extends \Model {


    // Properties
    protected $PayrollLevy;


    /**
     * PayrollLevyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->PayrollLevy = new PayrollLevy( );
    }


    /**
     * Return total count of records
     * @return int

    public function getUserPayroll( $pID, $userID ) {
        return $this->PayrollLevy->getUserPayroll( $pID, $userID );
    } */


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        $success = array( );

        if( isset( $data['puID'] ) && isset( $data['levy'] ) && sizeof( $data['levy'] ) ) {
            foreach( $data['levy'] as $levy ) {
                $info = array( );
                $info['puID'] = $data['puID'];
                $info['title'] = $levy['title'];
                $info['amount'] = $levy['amount'];
                array_push($success, $this->PayrollLevy->insert( 'payroll_levy', $info ) );
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->PayrollLevy->delete('payroll_levy',
                                       'WHERE plID NOT IN(' . implode(',', $success ) . ') AND 
                                                    puID = "' . (int)$data['puID'] . '"');
        }
        else {
            $this->PayrollLevy->delete('payroll_levy','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>