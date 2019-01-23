<?php
namespace Filters\Markaxis;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Markaxis\Employee\EmployeeModel;
use \Aurora\User\UserModel;
use \Library\Interfaces\IFilter, \Library\Util\FilterChain;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: EmployeeFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeFilter implements IFilter {


    // Properties


    /**
    * EmployeeFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Update UserLog Status
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getFieldByUserID( $userInfo['userID'], '*' );

        // We can check employee end date here to prevent access but I think for now
        // we move the check to cron. Anyway we still need this filter to load up
        // employee data for other object easy access.

        $FilterChain->doFilter( $Request, $Response );
    }
}
?>