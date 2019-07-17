<?php
namespace Markaxis\Company;
use \Aurora\Component\OfficeModel AS A_OfficeModel;
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


    /**
    * OfficeModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Office = new Office( );
	}


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $oID ) {
        $A_OfficeModel = A_OfficeModel::getInstance( );
        return $A_OfficeModel->getByoID( $oID );
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

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

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
     * Set Pay Item Info
     * @return int
     */
    public function getWorkingDays( $from, $to ) {
        $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
        $holidayDays = ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays

        $from = new DateTime( $from );
        $to = new DateTime( $to );
        $to->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $periods = new \DatePeriod( $from, $interval, $to );

        $days = 0;
        foreach( $periods as $period ) {
            if( !in_array( $period->format('N'), $workingDays ) ) continue;
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

            $DayHelper = DayHelper::getL10nList( );

            if( isset( $DayHelper[$data['workDayFrom']] ) ) {
                $this->info['workDayFrom'] = $data['workDayFrom'];
            }

            if( isset( $DayHelper[$data['workDayTo']] ) ) {
                $this->info['workDayTo'] = $data['workDayTo'];
            }

            $this->info['openTime'] = DateTime::createFromFormat('h:i A', $data['openTime'] )->format('H:i');
            $this->info['closeTime'] = DateTime::createFromFormat('h:i A', $data['closeTime'] )->format('H:i');
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