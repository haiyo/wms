<?php
namespace Library\Security\Aurora;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Runtime\Registry;
use \Library\Exception\Aurora\CSRFGuardException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CSRFGuard.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CSRFGuard {


    // Properties
    protected $Registry;


    /**
    * CSRFGuard Constructor
    * @return void
    */
    function __construct( ) {
        $this->Registry = Registry::getInstance( );
	}


    /**
    * Return a Unique CSRF Token
    * @return string
    */
    public function getCSRFToken( ) {
        return 'aurora-' . MD5( microtime( ) ) . '-csrfTokenv2';
	}


    /**
    * Set a Unique CSRF Token
    * @return void
    */
    public function setCSRFToken( ) {
        $csrfToken = $this->getCSRFToken( );
        $this->Registry->setCookie( 'csrfToken', $csrfToken );
        $this->Registry->set( HKEY_DYNAM, 'csrfToken', $csrfToken );
	}


    /**
    * Initialize CSRF Guard
    * @throws CSRFGuardException
    * @return void
    */
    public function init( HttpRequest $Request, HttpResponse $Response ) {
        if( !$Request->request( COOKIE, 'csrfToken' ) ) {
            $this->setCSRFToken( );
            //$this->injectJSToken( );
        }
        else {
            // Intercept POST
            if( sizeof( $Request->request( POST ) ) > 0 ) {
                if( !$Request->request( POST, 'csrfToken' ) ) {
                    throw( new CSRFGuardException( 'csrfToken token not found!' ) );
                }
                else if( $Request->request( COOKIE, 'csrfToken' ) != $Request->request( POST, 'csrfToken' ) ) {
                    throw( new CSRFGuardException( 'Incompatible csrfToken: Cookie: ' . htmlspecialchars( $Request->request( POST, 'csrfToken' ) ) .
                                                   ' Post: ' . htmlspecialchars( implode( ',', $Request->request( POST ) ) ) ) );
                }
            }
            $this->Registry->set( HKEY_DYNAM, 'csrfToken', $Request->request( COOKIE, 'csrfToken' ) );
        }
    }


    /**
    * Inject JavaScript Code to the Client. Usually use for first visit by the
    * client. If they fail this test, Aurora will disregard all entry.
    * @return void
    */
    public function injectJSToken( ) {
        /*echo '<script type="text/javascript" src="' . ROOT_URL . 'www/js/jquery/jquery.js"></script>
              <script type="text/javascript" src="' . ROOT_URL . 'www/js/jquery/jquery.cookie.js"></script>
              <script>
              $.ajax({ url: "' . ROOT_URL . 'admin/", type: "POST",
                  success: function(str) {
                      $.cookie( "csrfToken", "' . $this->getCSRFToken( ) . '", { path: "/" });
                      window.location.href = document.location.href;
                  }
              });
              </script>
              <noscript>JavaScript supported browser is required to run this site.</noscript>';*/
	}
}
?>