<?php
namespace Markaxis\Payroll;
use \Aurora\User\UserImageModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: SummaryModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SummaryModel extends \Model {


    // Properties
    protected $Summary;


    /**
     * SummaryModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Summary = new Summary( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByPuID( $puID ) {
        return $this->Summary->getByPuID( $puID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByPID( $pID ) {
        return $this->Summary->getByPID( $pID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getCountByDate( $date ) {
        return array( 'empCount' => $this->Summary->getCountByDate( $date ) );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post, $processDate, $officeID ) {
        $this->Summary->setLimit( $post['start'], $post['length'] );

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
        $results = $this->Summary->getResults( $processDate, $officeID, $post['search']['value'], $order . $dir );

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
     * @return mixed
     */
    public function processSummary( $data ) {
        $summary['gross'] = $summary['net'] = (float)$data['items']['totalOrdinary'];

        $summary['deduction'] = $summary['claim'] = $summary['fwl'] = $summary['sdl'] =
        $summary['levy'] = $summary['contribution'] = $summary['totalContribution'] = 0;

        if( isset( $data['addGross'] ) ) {
            foreach( $data['addGross'] as $addGross ) {
                $summary['gross'] += (float)$addGross;
                $summary['net']   += (float)$addGross;
            }
        }

        if( isset( $data['deductGross'] ) ) {
            foreach( $data['deductGross'] as $deductGross ) {
                $summary['gross'] -= (float)$deductGross;
                $summary['net']   -= (float)$deductGross;
            }
        }
        if( isset( $data['deductNet'] ) ) {
            foreach( $data['deductNet'] as $deductNet ) {
                $summary['net'] -= (float)$deductNet;
            }
        }

        if( isset( $data['claims'] ) ) {
            foreach( $data['claims'] as $claims ) {
                if( isset( $claims['eiID'] ) ) {
                    $summary['claim'] += (float)$claims['amount'];
                    $summary['net'] += (float)$claims['amount'];
                }
            }
        }

         if( isset( $data['contributions'] ) ) {
             foreach( $data['contributions'] as $contribution ) {
                 $summary['contribution'] += (float)$contribution['amount'];
             }
         }

        if( isset( $data['itemRow'] ) && is_array( $data['itemRow'] ) ) {
            foreach( $data['itemRow'] as $item ) {
                /*if( isset( $item['deductGross'] ) ) {
                    $summary['gross'] -= (float)$item['amount'];
                }
                if( isset($item['deduction']) || isset( $item['deductionAW'] ) ) {
                    $summary['net'] -= (float)$item['amount'];
                }*/

                foreach( $data['taxGroups']['mainGroup'] as $key => $taxGroup ) {
                    // First find all the childs in this group and see if we have any summary=1
                    if( isset( $taxGroup['child'] ) ) {
                        $tgIDChilds = array_unique( array_column( $taxGroup['child'],'tgID' ) );

                        if( isset( $item['tgID'] ) && in_array( $item['tgID'], $tgIDChilds ) ) {
                            foreach( $taxGroup['child'] as $childKey => $child ) {
                                if( isset( $child['tgID'] ) && $child['tgID'] == $item['tgID'] ) {
                                    if( $child['summary'] ) {
                                        $summary['itemGroups'][$childKey]['title'] = $child['title'];
                                        $summary['itemGroups'][$childKey]['remark'] = $item['remark'];
                                    }
                                    else {
                                        $summary['itemGroups'][$childKey]['title'] = $data['taxGroups']['mainGroup'][$child['parent']]['title'];
                                    }

                                    if( isset( $summary['itemGroups'][$childKey]['amount'] ) ) {
                                        $summary['itemGroups'][$childKey]['amount'] += (float)$item['amount'];
                                    }
                                    else {
                                        $summary['itemGroups'][$childKey]['amount'] = (float)$item['amount'];
                                    }
                                    break 2;
                                }
                            }
                        }
                    }
                    else if( isset( $taxGroup['tgID'] ) && isset( $item['tgID'] ) && $taxGroup['tgID'] == $item['tgID'] ) {
                        // If children not found with summary=1, fallback to parent
                        $summary['itemGroups'][$key]['title'] = $taxGroup['title'];
                        $summary['itemGroups'][$key]['amount'] = (float)$item['amount'];
                        break;
                    }
                }
            }
        }
        /*
        if( isset( $data['skillLevy'] ) ) {
            $summary['sdl'] += (float)$data['skillLevy']['amount'];
            $summary['levy'] += (float)$data['skillLevy']['amount'];
        }
        if( isset( $data['foreignLevy'] ) ) {
            $summary['fwl'] += (float)$data['foreignLevy']['amount'];
            $summary['levy'] += (float)$data['foreignLevy']['amount'];
        }
        */
        return $summary;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $data ) {
        if( isset( $data['puID'] ) ) {
            $summary = $this->processSummary( $data );

            $info = array( );
            $info['pID'] = $data['payrollInfo']['pID'];
            $info['puID'] = $data['puID'];
            $info['gross'] = $summary['gross'];
            $info['deduction'] = $summary['deduction'];
            $info['levy'] = $summary['levy'];
            $info['contribution'] = $summary['contribution'];
            $info['net'] = $summary['net'];
            $info['claim'] = $summary['claim'];

            if( $summaryInfo = $this->getByPuID( $data['puID'] ) ) {
                $this->Summary->update( 'payroll_summary', $info,
                                               'WHERE psID = "' . (int)$summaryInfo['psID'] . '"' );

                return $summaryInfo['psID'];
            }
            else {
                return $this->Summary->insert('payroll_summary', $info );
            }
        }
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayroll( $data ) {
        if( isset( $data['puID'] ) ) {
            $this->Summary->delete('payroll_summary','WHERE puID = "' . (int)$data['puID'] . '"');
        }
    }
}
?>