<?php
namespace Markaxis\Leave;
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
        $this->info['applied'] = 'hired';
        $this->info['unused'] = 'forfeit';
        $this->info['gender'] = 'all';
        $this->info['office'] = 'all';
        $this->info['designation'] = 'all';
        $this->info['contract'] = 'all';
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
    public function getFullList( ) {
        return $this->info = $this->Type->getFullList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        $this->info = array( );
        $this->info['name'] = Validator::stripTrim( $data['leaveTypeName'] );
        $this->info['code'] = Validator::stripTrim( $data['leaveCode'] );

        if( isset( PaidLeaveHelper::getL10nList( )[$data['paidLeave']] ) ) {
            $this->info['paidLeave'] = $data['paidLeave'];
        }
        if( isset( HalfDayHelper::getL10nList( )[$data['allowHalfDay']] ) ) {
            $this->info['allowHalfDay'] = $data['allowHalfDay'];
        }
        if( isset( AppliedHelper::getL10nList( )[$data['applied']] ) ) {
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
        }

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
        $Type = new Type( );

        if( $data['ltID'] && $this->isFound( $data['ltID'] ) ) {
            $ltID = (int)$data['ltID'];
            $Type->update( 'leave_type', $this->info, 'WHERE ltID = "' . $ltID . '"' );
        }
        else {
            $ltID = $Type->insert('leave_type', $this->info);
        }
        return $ltID;
    }
}
?>