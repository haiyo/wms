<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ContributionModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContributionModel extends \Model {


    // Properties
    protected $Contribution;


    /**
     * ContributionModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Contribution = new Contribution( );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByPuID( $puID ) {
        return $this->Contribution->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getChart( $date ) {
        return array( 'contributions' => $this->Contribution->getChart( $date ) );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getExistingContributions( $data ) {
        $contributions = array( );

        if( isset( $data['payrollUser']['puID'] ) ) {
            $listContri = $this->getByPuID( $data['payrollUser']['puID'] );

            if( sizeof( $listContri ) > 0 ) {
                foreach( $listContri as $contri ) {
                    $contributions[] = array( 'title' => $contri['title'],
                                              'amount' => $contri['amount'] );
                }
            }
        }
        return $contributions;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        $success = array( );

        if( isset( $data['puID'] ) && isset( $data['contributions'] ) && sizeof( $data['contributions'] ) ) {
            foreach( $data['contributions'] as $contribution ) {
                $info = array( );
                $info['puID'] = $data['puID'];
                $info['title'] = $contribution['title'];
                $info['trID'] = $contribution['trID'];
                $info['amount'] = $contribution['amount'];
                array_push($success, $this->Contribution->insert( 'payroll_contribution', $info ) );
            }
        }
        if( sizeof( $success ) > 0 ) {
            $this->Contribution->delete('payroll_contribution',
                                        'WHERE pcID NOT IN(' . implode(',', $success ) . ') AND 
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
            $this->Contribution->delete('payroll_contribution','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>