<?php
namespace Filters\Aurora;
use \Library\IO\File, \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Aurora\User\Userlog, \Aurora\User\UserModel;
use \Library\Runtime\Registry, \IFilter, \FilterChain;
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

        File::import( MODEL . 'Aurora/User/UserModel.class.php' );
        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        File::import( DAO . 'Aurora/User/UserLog.class.php' );
        $UserLog = new UserLog( );
        $UserLog->updateStatus( $userInfo['userID'], 1 );
        
        $Registry->set( HKEY_CLASS, 'UserLog', $UserLog );
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>