<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserItem.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserItem extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByPuID( $puID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_user_item pui
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE pui.puID = "' . (int)$puID . '"
                                   ',
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
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalGrossByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.basic = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalAdditionalByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.additional = "1" AND
                                         p.completed = "1"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalDirectorFeeByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount, pui.remark FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.directorFee = "1" AND
                                         p.completed = "1"
                                   GROUP BY pui.remark',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalTransportByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.transport = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalEntertainmentByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.entertainment = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalOtherAllowanceByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.allowanceOthers = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalCommissionByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT p.startDate, pui.amount AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.commission = "1" AND
                                         p.completed = "1"',
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
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalPensionByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.pension = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalGratuityByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.gratuity = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalNoticeByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.notice = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalExGratiaByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.exgratia = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalOtherLumpsumByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount, pui.remark FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.lumpSumOthers = "1" AND
                                         p.completed = "1"
                                   GROUP BY pui.remark',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalStockByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(pui.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_item pui ON ( pui.puID = pu.puID )
                                   LEFT JOIN payroll_item pi ON ( pi.piID = pui.piID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         pi.stock = "1" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>