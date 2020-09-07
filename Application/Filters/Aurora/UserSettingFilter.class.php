<?php
namespace Filters\Aurora;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Aurora\User\UserSettingModel, \Aurora\User\UserModel;
use \Library\Runtime\Registry, \Library\Interfaces\IFilter, \Library\Util\FilterChain;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserSettingFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserSettingFilter implements IFilter {


    // Properties


    /**
    * UserSettingFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Load User Settings
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        $Registry = Registry::getInstance( );

        $UserModel = UserModel::getInstance( );
        $userInfo = $UserModel->getInfo( );

        $UserSettingModel = new UserSettingModel( );
        $UserSettingModel->load( $userInfo['userID'] );
        $userSetInfo = $UserSettingModel->getInfo( );

        if( $userSetInfo['lang'] ) {
            $Registry->setCookie( 'lang', $userSetInfo['lang'] );
        }

        $Registry->set( HKEY_CLASS, 'UserSettingModel', $UserSettingModel );
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>