<?php
namespace Filters\Aurora;
use \Aurora\User\UserModel;
use \Library\IO\File, \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Security\Aurora\Authorization;
use \Library\Exception\Aurora\NoPermissionException;
use \Library\Runtime\Registry, \IFilter, \FilterChain;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AuthorizationFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AuthorizationFilter implements IFilter {


    // Properties


    /**
    * AuthorizationFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Authorization Filter
    * @throws NoPermissionException
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        $Registry = Registry::getInstance( );

        File::import( MODEL . 'Aurora/User/UserModel.class.php' );
        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        File::import( LIB . 'Security/Aurora/Authorization.dll.php' );
        $Authorization = new Authorization( );
        $Authorization->load( $userInfo['userID'] );

        if( !$Request->request( POST, 'auroraForgotPassword' ) &&
            !$Authorization->hasPermission( 'Aurora', 'admin_login' ) ) {
            $Registry->setCookie( 'userID',   '' );
            $Registry->setCookie( 'sessHash', '' );
            $Response->setCode( HttpResponse::HTTP_FORBIDDEN );
            throw( new NoPermissionException( HttpResponse::HTTP_FORBIDDEN ) );
        }
        $Registry->set( HKEY_CLASS, 'Authorization', $Authorization );
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>