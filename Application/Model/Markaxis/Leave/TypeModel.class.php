<?php
namespace Markaxis\Leave;
use \Library\Helper\Markaxis\PaidLeaveHelper;
use \Library\Helper\Markaxis\HalfDayHelper;
use \Library\Helper\Markaxis\AppliedHelper;
use \Library\Helper\Markaxis\LeavePeriodHelper;
use \Library\Helper\Markaxis\ProRatedHelper;
use \Library\Helper\Markaxis\UnusedLeaveHelper;
use \Library\Helper\Markaxis\CarryPeriodHelper;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TypeModel extends \Model {


    // Properties
    protected $Type;


    /**
     * TypeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Type = new Type( );

        $this->info['name'] = '';
        $this->info['code'] = '';
        $this->info['proRated'] = 0;
        $this->info['allowHalfDay'] = 0;
        $this->info['paidLeave'] = 1;
        $this->info['formula'] = '';
        $this->info['applied'] = 'hired';
        $this->info['unused'] = 'forfeit';
        $this->info['haveChild'] = 0;
        $this->info['childBorn'] = '';
        $this->info['childAge'] = '';
        $this->info['pPeriod'] = '';
        $this->info['cPeriod'] = '';
        $this->info['uPeriod'] = '';
        $this->info['pPeriodType'] = '';
        $this->info['cPeriodType'] = '';
        $this->info['uPeriodType'] = '';
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->Type->isFound( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $ltID ) {
        return $this->info = $this->Type->getByID( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByIDs( $ltIDs ) {
        return $this->Type->getByIDs( $ltIDs );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Type->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByChart( ) {
        $this->Type->setLimit(0,4 );
        return $this->Type->getByChart( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getFullList( ) {
        return $this->info = $this->Type->getFullList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Type->setLimit( $post['start'], $post['length'] );

        $order = 'lt.name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'lt.name';
                    break;
                case 2:
                    $order = 'lt.code';
                    break;
                case 3:
                    $order = 'lt.paidLeave';
                    break;
                case 4:
                    $order = 'lt.allowHalfDay';
                    break;
                case 5:
                    $order = 'lt.applied';
                    break;
                case 6:
                    $order = 'lt.unused';
                    break;
            }
        }
        $results = $this->Type->getResults( $post['search']['value'], $order . $dir );

        if( sizeof( $results ) ) {
            foreach( $results as $key => $row ) {
                if( isset( $row['applied'] ) ) {
                    $results[$key]['applied'] = AppliedHelper::getL10nList( )[$row['applied']];
                }
                if( isset( $row['unused'] ) ) {
                    $results[$key]['unused'] = UnusedLeaveHelper::getL10nList( )[$row['unused']];
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
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        $this->info = array( );
        $this->info['name'] = Validator::stripTrim( $data['leaveTypeName'] );
        $this->info['code'] = Validator::stripTrim( $data['leaveCode'] );

        if( isset( $data['formula'] ) ) {
            $this->info['formula'] = Validator::stripTrim( $data['formula'] );
        }

        if( isset( $data['paidLeave'] ) && isset( PaidLeaveHelper::getL10nList( )[$data['paidLeave']] ) ) {
            $this->info['paidLeave'] = $data['paidLeave'];
        }
        if( isset( $data['allowHalfDay'] ) && isset( HalfDayHelper::getL10nList( )[$data['allowHalfDay']] ) ) {
            $this->info['allowHalfDay'] = $data['allowHalfDay'];
        }
        /*if( isset( AppliedHelper::getL10nList( )[$data['applied']] ) ) {
            $this->info['applied'] = $data['applied'];

            if( $this->info['applied'] == 'probation' ) {
                $pPeriodValue = (int)$data['pPeriodValue'];

                if( $pPeriodValue > 0 && isset( LeavePeriodHelper::getL10nList( )[$data['pPeriodType']] ) ) {
                    $this->info['pPeriod'] = $pPeriodValue ;
                    $this->info['pPeriodType'] = $data['pPeriodType'];
                }
            }
        }

        if( isset( ProRatedHelper::getL10nList( )[$data['proRated']] ) ) {
            $this->info['proRated'] = $data['proRated'];
        }*/
        if( isset( UnusedLeaveHelper::getL10nList( )[$data['unused']] ) ) {
            $this->info['unused'] = $data['unused'];

            if( $this->info['unused'] == 'carry' ) {
                $cPeriodValue = (int)$data['cPeriodValue'];
                $usedValue = (int)$data['usedValue'];

                if( $cPeriodValue > 0 && isset( CarryPeriodHelper::getL10nList( )[$data['cPeriodType']] ) ) {
                    $this->info['cPeriod'] = $cPeriodValue;
                    $this->info['cPeriodType'] = $data['cPeriodType'];

                    if( $usedValue > 0 && isset( LeavePeriodHelper::getL10nList( )[$data['usedType']] ) ) {
                        $this->info['uPeriod'] = $usedValue;
                        $this->info['uPeriodType'] = $data['usedType'];
                    }
                }
            }
        }

        if( $data['ltID'] && $this->isFound( $data['ltID'] ) ) {
            $ltID = (int)$data['ltID'];
            $this->Type->update( 'leave_type', $this->info, 'WHERE ltID = "' . $ltID . '"' );
        }
        else {
            $ltID = $this->Type->insert('leave_type', $this->info);
        }
        return $ltID;
    }
}
?>