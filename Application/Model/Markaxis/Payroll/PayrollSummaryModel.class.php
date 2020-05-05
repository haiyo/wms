<?php
namespace Markaxis\Payroll;
use \Aurora\User\UserImageModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollSummaryModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollSummaryModel extends \Model {


    // Properties
    protected $PayrollSummary;


    /**
     * PayrollSummaryModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->PayrollSummary = new PayrollSummary( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByPuID( $puID ) {
        return $this->PayrollSummary->getByPuID( $puID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post, $processDate ) {
        $this->PayrollSummary->setLimit( $post['start'], $post['length'] );

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'e.idnumber';
                    break;
                case 2:
                    $order = 'name';
                    break;
                case 3:
                    $order = 'd.title';
                    break;
                case 4:
                    $order = 'e.email1';
                    break;
                case 5:
                    $order = 'u.mobile';
                    break;
                case 6:
                    $order = 'u.suspended';
                    break;
            }
        }
        $results = $this->PayrollSummary->getResults( $processDate, $post['search']['value'], $order . $dir );

        if( $results ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $results as $key => $row ) {
                if( isset( $row['userID'] ) ) {
                    $results[$key]['photo'] = $UserImageModel->getImgLinkByUserID( $row['userID'] );
                }
            }
        }

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        if( isset( $data['puID'] ) ) {
            $info = array( );
            $info['pID'] = $data['pID'];
            $info['puID'] = $data['puID'];
            $info['gross'] = $data['summary']['gross'];
            $info['deduction'] = $data['summary']['deduction'];
            $info['net'] = $data['summary']['net'];
            $info['claim'] = $data['summary']['claim'];

            if( $summaryInfo = $this->getByPuID( $data['puID'] ) ) {
                $this->PayrollSummary->update( 'payroll_summary', $info,
                                               'WHERE psID = "' . (int)$summaryInfo['psID'] . '"' );

                return $summaryInfo['psID'];
            }
            else {
                return $this->PayrollSummary->insert('payroll_summary', $info );
            }
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['puID'] ) ) {
            $this->PayrollSummary->delete('payroll_summary','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>