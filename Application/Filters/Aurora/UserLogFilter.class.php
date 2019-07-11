<?php
namespace Filters\Aurora;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Aurora\User\UserLog, \Aurora\User\UserModel;
use \Library\Runtime\Registry, \Library\Interfaces\IFilter, \Library\Util\FilterChain;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: UserLogFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserLogFilter implements IFilter {


    // Properties


    /**
    * UserLogFilter Constructor
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
        $Registry = Registry::getInstance( );

        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        $UserLog = new UserLog( );
        $UserLog->updateStatus( $userInfo['userID'], 1 );
        
        $Registry->set( HKEY_CLASS, 'UserLog', $UserLog );
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>