<?php
namespace Aurora;
use \File, \String, \HTMLSanitizer;
use \DOMDocument, \DOMXPath;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: WikiGrabber.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class WikiGrabber extends URLGrabber implements IURLGrabber {


    // Properties


    /**
     * WikiGrabber Constructor
     * @return void
     */
    function __construct( $url ) {
        parent::__construct( $url );
    }


    /**
     * Grab content from URL
     * @return void
     */
    public function getInfo( ) {
        $DOM = new DOMDocument( );
        $content = $this->getURLPage( );

        File::import( LIB . 'Sanitizer/HTMLSanitizer.dll.php' );
        $content = HTMLSanitizer::sanitize( $content['content'] );

        if( !@$DOM->loadHTML( $content ) ) {
            return false;
        }
        else {
            $XPath = new DOMXPath( $DOM );
            $info  = array( );
            $info['title'] = strip_tags( trim( $XPath->query('//title')->item(0)->nodeValue ) );

            if( $info['title'] != '' ) {
                File::import( LIB . 'Util/String.dll.php' );
                $String = new String( );
                $info['title'] = str_replace( 'Incompatible Browser | ', '', $info['title'] );
                $info['title'] = $String->cropText( $info['title'], 300 );
                $info['url']   = $String->cropText( $this->url, 300 );

                //preg_match( '/<meta[^>]*description[^>]*content=\"([^>]+)\"[^>]*>/Ui', $content, $match );
                $info['description'] = '';
                $pTags = $DOM->getElementsByTagName('p');
                foreach( $pTags as $pTag ) {
                    $nodeValue = strip_tags( $pTag->nodeValue );
                    if( strlen( $nodeValue ) > 300 ) {
                        $info['description'] = $String->cropText( $String->makeLink( $nodeValue ), 400 );
                        break;
                    }
                }
                $info['thumbnail'] = array( );
                $images = $DOM->getElementsByTagName('images');
                foreach( $images as $image ) {
                    $src = $image->getAttribute('src');
                    if( substr( $src, -3, strlen($src) ) != 'gif' && !stristr( $src, '20px-Padlock-silver.svg.png' ) ) {
                        if( preg_match( '#^(//)#', $src ) ) {
                            $src = 'http:' . $src;
                        }
                        else {
                            $src = $this->rel2abs( $src, $this->url );
                        }

                        if( !in_array( $src, $info['thumbnail'] ) ) {
                            $info['thumbnail'][] = $src;
                        }
                    }
                }
                return $info;
            }
        }
    }


    /**
     * Grab content using Wiki API - Deprecated
     * All mediawiki API are damn lousy! Not only return different content (No standard) but
     * with lots of junk!
     * @return mixed
     
    public function getInfo( ) {
        $oldURL = $this->url;
        preg_match("#^(\w+://)?([^\"]+\.org+)(%2Fwiki%2F+)(.+)$#Uis", urlencode( $this->url ), $match );

        if( isset( $match[2] ) && isset( $match[4] ) ) {
            $this->url = urldecode( $match[2] ) . '/w/api.php?action=query&titles=' . urldecode( $match[4] ) . '&prop=revisions&rvprop=content&format=php';
            echo $this->url; exit;
            $content   = $this->getURLPage( );
            $content   = unserialize( $content['content'] );
            $this->url = $oldURL;

            $info = array( );
            if( isset( $content['query']['pages'] ) ) {
                File::import( LIB . 'Util/String.dll.php' );
                $String = new String( );

                while( list( $pageID, $data ) = each( $content['query']['pages'] ) ) {
                    while( list( $key, $value ) = each( $data) ) {
                        if( $key == 'title' ) {
                            $info['title'] = $String->cropText( $String->makeLink( (string)$value ), 300 );
                        }
                        if( $key == 'revisions' && isset( $value[0]['*'] ) ) {
                            $value[0]['*'] = preg_replace( '/({{+)(.*)(}}<!+)/sim', '', $value[0]['*'] );
                            $value[0]['*'] = preg_replace( '/(--+)(.*)(-->)/', '', $value[0]['*'] );
                            $value[0]['*'] = preg_replace( '/(\r?\n)/', '', $value[0]['*'] );
                            $info['description'] = $String->cropText( $String->makeLink( (string)$value[0]['*'] ), 300 );
                        }
                    }
                }
            }
        }

        if( $info['title'] ) {
            $info['url'] = (string)$oldURL;
            $info['thumbnail'] = array( );

            $DOM = new DOMDocument( );
            $content = $this->getURLPage( );

            File::import( LIB . 'Sanitizer/HTMLSanitizer.dll.php' );
            $content = HTMLSanitizer::sanitize( $content['content'] );

            if( !@$DOM->loadHTML( $content ) ) {
                return false;
            }
            else {
                $XPath  = new DOMXPath( $DOM );
                $images = $DOM->getElementsByTagName('images');
                foreach( $images as $image ) {
                    $src = $image->getAttribute('src');
                    if( substr( $src, -3, strlen($src) ) != 'gif' ) {
                        if( preg_match( '#^(//)#', $src ) ) {
                            $src = 'http:' . $src;
                        }
                        else {
                            $src = $this->rel2abs( $src, $this->url );
                        }
                        if( !in_array( $src, $info['thumbnail'] ) ) {
                            $info['thumbnail'][] = $src;
                        }
                    }
                }
            }
            return $info;
        }
    }*/
}
?>