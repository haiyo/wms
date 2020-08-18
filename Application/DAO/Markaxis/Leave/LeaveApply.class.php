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
     * Return total count of records
     * @return int
     */
    public function isFoundByLaIDUserID( $laID, $userID, $status ) {
        $sql = $this->DB->select( 'SELECT COUNT(laID) FROM leave_apply 
                                   WHERE laID = "' . (int)$laID . '" AND
                                         userID = "' . (int)$userID . '" AND
                                         status = "' . (int)$status . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $status ) {
        $sql = $this->DB->select( 'SELECT COUNT(laID) FROM leave_apply 
                                   WHERE userID = "' . (int)$userID . '" AND
                                         status = "' . (int)$status . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
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
    public function getHistory( $userID, $q='', $order='la.created DESC' ) {
        $q = '';
        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS la.laID, la.reason, la.uID, la.cancelled,
                                          DATE_FORMAT( la.startDate, "%D %b %Y") AS startDate, 
                                          DATE_FORMAT( la.endDate, "%D %b %Y") AS endDate,
                                          la.days, la.status, la.created, lt.name, lt.code,
                                          u.name AS uploadName, u.hashName
                                   FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   LEFT JOIN upload u ON ( u.uID = la.uID )
                                   WHERE la.userID = "' . (int)$userID . '" ' . $q . '
                                   ORDER BY ' . $order . $this->limit,
                                   __FILE__, __LINE__ );

        $list = array( );

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
        $sql = $this->DB->select( 'SELECT lt.name, lt.code, u.userID, u.fname, u.lname, la.reason, la.uID,
                                          la.laID, la.days, la.created, up.hashDir, up.hashName, up.name AS uploadName, 
                                          DATE_FORMAT( la.startDate, "%D %b %Y") AS startDate, 
                                          DATE_FORMAT( la.endDate, "%D %b %Y") AS endDate
                                   FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   LEFT JOIN leave_apply_manager lam ON ( lam.laID = la.laID )
                                   LEFT JOIN user u ON ( u.userID = la.userID )
                                   LEFT JOIN upload up ON ( up.uID = la.uID )
                                   WHERE lam.managerID = "' . (int)$userID . '" AND 
                                         lam.approved = "0" AND
                                         la.cancelled <> "1" AND
                                         lt.deleted <> "1"
                                   ORDER BY la.created desc',
                                   __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getRequest( $userID ) {
        $sql = $this->DB->select( 'SELECT lt.name, lt.code, u.userID, u.fname, u.lname, la.reason, la.uID,
                                          la.laID, la.days, la.created, la.status,
                                          up.hashDir, up.hashName, up.name AS uploadName,
                                          DATE_FORMAT( la.startDate, "%D %b %Y") AS startDate, 
                                          DATE_FORMAT( la.endDate, "%D %b %Y") AS endDate
                                   FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   LEFT JOIN user u ON ( u.userID = la.userID )
                                   LEFT JOIN upload up ON ( up.uID = la.uID )
                                   WHERE la.userID = "' . (int)$userID . '" AND 
                                         la.status = "0" AND
                                         la.cancelled <> "1" AND
                                         lt.deleted <> "1"
                                   ORDER BY la.created desc',
                                   __FILE__, __LINE__ );
        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getByUserLeaveTypeCurrYear( $userID, $ltID ) {
        $sql = $this->DB->select( 'SELECT la.* FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   WHERE YEAR( la.startDate ) = YEAR( CURDATE( ) ) AND
                                         la.ltID = "' . (int)$ltID . '" AND
                                         la.userID = "' . (int)$userID . '" AND 
                                         ( la.status = "1" OR la.status = "0" ) AND
                                         la.cancelled = "0" AND
                                         lt.deleted = "0"',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
 * Retrieve a user column by userID
 * @return mixed
 */
    public function getUnPaidByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT la.*, lt.name, lt.formula FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   WHERE la.userID = "' . (int)$userID . '" AND 
                                         la.status = "1" AND
                                         la.cancelled = "0" AND
                                         lt.paidLeave = "0" AND
                                         lt.deleted = "0"',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getWhosOnLeave( $date ) {
        $sql = $this->DB->select( 'SELECT u.userID, CONCAT( u.fname, " ", u.lname ) AS name
                                   FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   LEFT JOIN user u ON ( u.userID = la.userID )
                                   WHERE la.startDate <= "' . addslashes( $date ) . '" AND
                                         la.endDate >= "' . addslashes( $date ) . '" AND
                                         la.status = "1" AND
                                         la.cancelled = "0" AND
                                         lt.deleted = "0"',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getEvents( $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT CONCAT( u.fname, " ", u.lname ) AS name,
                                          la.*, la.startDate AS start, la.endDate AS end,
                                          lt.name AS title FROM leave_apply la
                                   LEFT JOIN leave_type lt ON ( lt.ltID = la.ltID )
                                   LEFT JOIN user u ON ( u.userID = la.userID )
                                   WHERE la.startDate BETWEEN "' . addslashes( $startDate ) . '" AND 
                                                              "' . addslashes( $endDate ) . '" AND
                                         la.status = "1" AND
                                         la.cancelled = "0" AND
                                         lt.deleted = "0"',
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