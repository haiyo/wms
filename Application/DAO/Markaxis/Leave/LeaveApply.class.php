<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveApply.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveApply extends \DAO {


    // Properties


    /**
     * LeaveApply Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getSidebarByUserID( $userID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT elb.ltID, la.days FROM employee_leave_bal elb
                                   LEFT JOIN ( SELECT ltID, SUM(days) AS days 
                                               FROM leave_apply WHERE userID = "' . (int)$userID . '"
                                               GROUP BY ltID ) AS la ON la.ltID = elb.ltID
                                   WHERE elb.userID = "' . (int)$userID . '" AND elb.sidebar = "1"
                                   GROUP BY elb.ltID',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['ltID']] = $row['days'];
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getHistory( $q='', $order='name ASC' ) {
        $list = array( );

        /*if( $q == 'active' ) {
            $q = 'AND u.suspended = "0"';
        }
        else {
            $q = $q ? addslashes( $q ) : '';
            $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" OR d.title LIKE "%' . $q . '%" 
                       OR e.idnumber = "' . $q . '" OR u.email1 LIKE "%' . $q . '%" OR e.startdate LIKE "%' . $q . '%"
                       OR c.type LIKE "%' . $q . '%" )' : '';
        }*/
        $q = '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS la.laID, la.reason, la.cancelled,
                                          DATE_FORMAT( la.startDate, "%D %b %Y") AS startDate, 
                                          DATE_FORMAT( la.endDate, "%D %b %Y") AS endDate,
                                          la.days, la.status, la.created, lt.name, lt.code
                                   FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   WHERE 1 = 1 ' . $q . '
                                   ORDER BY ' . $order . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        $sql = $this->DB->select( 'SELECT FOUND_ROWS()', __FILE__, __LINE__ );
        $row = $this->DB->fetch( $sql );
        $list['recordsTotal'] = $row['FOUND_ROWS()'];
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getPendingAction( $userID ) {
        $sql = $this->DB->select( 'SELECT lt.name, lt.code, u.fname, u.lname, la.reason,
                                          la.laID, la.days, la.created,
                                          DATE_FORMAT( la.startDate, "%D %b %Y") AS startDate, 
                                          DATE_FORMAT( la.endDate, "%D %b %Y") AS endDate
                                   FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   LEFT JOIN leave_apply_manager lam ON ( lam.laID = la.laID )
                                   LEFT JOIN user u ON ( u.userID = la.userID )
                                   WHERE lam.managerID = "' . (int)$userID . '" AND 
                                         lam.approved = "0" AND
                                         la.cancelled <> "1" AND
                                         lt.deleted <> "1"',
                                   __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>