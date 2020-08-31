<?php
namespace Markaxis\Company;
use \Aurora\Component\OfficeModel AS A_OfficeModel;
use \Markaxis\Leave\HolidayModel;
use \Aurora\Component\CountryModel, \Library\Helper\Aurora\DayHelper;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: OfficeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeModel extends \Model {


    // Properties
    protected $Office;
    protected $L10n;


    /**
    * OfficeModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $i18n->loadLanguage('Markaxis/Company/OfficeRes');

        $this->Office = new Office( );
	}


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $oID ) {
        $A_OfficeModel = A_OfficeModel::getInstance( );
        return $A_OfficeModel->isFound( $oID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByoID( $oID ) {
        $A_OfficeModel = A_OfficeModel::getInstance( );
        return $A_OfficeModel->getByoID( $oID );
    }


    /**
    * Return total count of records
    * @return int
    */
    public function getList( ) {
        return $this->Office->getList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Office->setLimit( $post['start'], $post['length'] );

        $order = 'main';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'asc' ? ' asc' : ' desc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'name';
                    break;
                case 2:
                    $order = 'address';
                    break;
                case 3:
                    $order = 'country';
                    break;
                case 4:
                    $order = 'staff';
                    break;
            }
        }
        $results = $this->Office->getResults( $post['search']['value'], $order . $dir );

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
    public function getWorkingDaysByOfficeID( $oID ) {
        $officeInfo = $this->getByoID( $oID );
        $workDays = array( );

        if( $officeInfo['workDayFrom'] && $officeInfo['workDayTo'] ) {
            $workDay = array( (int)$officeInfo['workDayFrom'], (int)$officeInfo['workDayTo'] );

            for( $i=$workDay[0]; $i<=$workDay[1]; $i++ ) {
                $workDays[] = $i;
            }
        }
        return $workDays;
    }


    /**
     * Set Pay Item Info
     * @return int
     */
    public function getWorkingDaysByRange( $oID, $startDate, $endDate, $countryCode ) {
        $workDays = $this->getWorkingDaysByOfficeID( $oID );

        $HolidayModel = new HolidayModel( );
        $holidayInfo = $HolidayModel->getNonWorkDays( $startDate, $endDate, $countryCode );
        $holidayDays = [];

        if( sizeof( $holidayInfo ) > 0 ) {
            $holidayDays = array_column( $holidayInfo, 'date' );
        }
        $from = new DateTime( $startDate );
        $to = new DateTime($endDate . ' 23:59:59' );

        $interval = new \DateInterval('P1D');
        $periods = new \DatePeriod( $from, $interval, $to );

        $days = 0;
        foreach( $periods as $period ) {
            if( !in_array( $period->format('N'), $workDays ) ) continue;
            if(  in_array( $period->format('Y-m-d'), $holidayDays ) ) continue;
            if(  in_array( $period->format('*-m-d'), $holidayDays ) ) continue;
            $days++;
        }
        return $days;
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $Validator = new Validator( );

        $this->info['oID'] = (int)$data['officeID'];
        $this->info['name'] = Validator::stripTrim( $data['officeName'] );
        $this->info['address'] = Validator::stripTrim( $data['officeAddress'] );

        $CountryModel = CountryModel::getInstance( );
        if( $CountryModel->isFound( $data['officeCountry'] ) ) {
            $this->info['countryID'] = (int)$data['officeCountry'];
        }

        $OfficeTypeModel = OfficeTypeModel::getInstance( );
        if( $OfficeTypeModel->isFound( $data['officeType'] ) ) {
            $this->info['officeTypeID'] = (int)$data['officeType'];
        }

        $Validator->addModule( 'officeName', new IsEmpty( $this->info['name'] ) );

        try {
            $Validator->validate( );
            $DayHelper = DayHelper::getL10nNumericValueList( );
            $this->info['days'] = 0;

            if( isset( $data['workDayFrom'] ) && isset( $DayHelper[$data['workDayFrom']] ) ) {
                $this->info['workDayFrom'] = $data['workDayFrom'];
            }

            if( isset( $data['workDayTo'] ) && isset( $DayHelper[$data['workDayTo']] ) ) {
                $this->info['workDayTo'] = $data['workDayTo'];
            }

            if( isset( $this->info['workDayFrom'] ) && isset( $this->info['workDayTo'] ) ) {
                for( $i=$this->info['workDayFrom']; $i<$this->info['workDayTo']; $i++ ) {
                    $this->info['days']++;
                }
            }

            if( isset( $data['halfDay'] ) ) {
                $this->info['halfDay'] = 1;
                $this->info['days'] += .5;
            }
            $this->info['main'] = isset( $data['main'] ) ? 1 : 0;

            if( $this->info['oID'] && !$this->info['main'] ) {
                // if not set to main, then we need to double check we have at least 1 main office.
                $A_OfficeModel = A_OfficeModel::getInstance( );
                $mainInfo = $A_OfficeModel->getMainOffice( );

                if( $mainInfo['oID'] == $this->info['oID'] ) {
                    $this->setErrMsg( $this->L10n->getContents('LANG_MUST_AT_LEAST_ONE_MAIN') );
                    return false;
                }
            }
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }
        return true;
    }


    /**
     * Save Pay Item information
     * @return int
     */
    public function save( ) {
        if( !$this->info['oID'] ) {
            unset( $this->info['oID'] );
            $this->info['oID'] = $this->Office->insert( 'office', $this->info );
        }
        else {
            $this->Office->update( 'office', $this->info, 'WHERE oID = "' . (int)$this->info['oID'] . '"' );
        }

        // If this is set to main office, then we set all others to 0.
        if( $this->info['main'] ) {
            $info = array( );
            $info['main'] = 0;
            $this->Office->update( 'office', $info, 'WHERE oID <> "' . (int)$this->info['oID'] . '"' );
        }
        return $this->info['oID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $oID ) {
        $A_OfficeModel = A_OfficeModel::getInstance( );

        if( $A_OfficeModel->isFound( $oID ) ) {
            $info = array( );
            $info['deleted'] = 1;
            $this->Office->update( 'office', $info, 'WHERE oID = "' . (int)$oID . '"' );
        }
    }
}
?>