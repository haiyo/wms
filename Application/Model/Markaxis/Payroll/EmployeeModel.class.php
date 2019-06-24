<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: EmployeeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeModel extends \Model {


    // Properties
    protected $Employee;



    /**
     * EmployeeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $this->Employee = new Employee( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getProcessInfo( $userID ) {
        $empInfo = $this->Employee->getProcessInfo( $userID );
        $empInfo['monthDiff'] = 0;

        if( $empInfo['startDate'] ) {
            $currYear  = date( 'Y' );
            $dateDiff  = \DateTime::createFromFormat('jS M Y',
                            $empInfo['startDate'] )->diff( new \DateTime('now') );

            if( $dateDiff->y < $currYear ) {
                $empInfo['monthDiff'] = 12;
            }
            else if( $dateDiff->y == $currYear ) {
                $begin = new \DateTime($dateDiff->d . '-' . $dateDiff->m . '-' . $currYear );
                $end = new \DateTime( );
                $end = $end->modify( '+1 month' );

                $interval = \DateInterval::createFromDateString('1 month');
                $period = new \DatePeriod( $begin, $interval, $end );

                foreach( $period as $dt ) {
                    $empInfo['monthDiff']++;
                }
            }
        }
        return $empInfo;
    }
}
?>