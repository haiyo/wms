<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TimesheetModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TimesheetModel extends \Model {


    // Properties



    /**
     * TimesheetModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );

        $this->info['userID'] = $this->info['salary'] = 0;
        $this->info['idnumber'] = $this->info['currency'] =
        $this->info['bankNumber'] = $this->info['bankCode'] =
        $this->info['branchCode'] = $this->info['bankHolderName'] = $this->info['swiftCode'] =
        $this->info['branchName'] = $this->info['passNumber'] = $this->info['confirmDate'] =
        $this->info['startDate'] = $this->info['endDate'] = $this->info['passExpiryDate'] = '';
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $eID ) {
        $Employee = new Employee( );
        return $Employee->isFound( $eID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        $Employee = new Employee( );
        return $Employee->isFoundByUserID( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getList( ) {
        $Employee = new Employee( );
        return $Employee->getList( );
    }
}
?>