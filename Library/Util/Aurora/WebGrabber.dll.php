<?php
namespace Library\Util\Aurora;
use \Library\Interfaces\IURLGrabber;
use \Library\Util\MXString;
use \DOMDocument, \DOMXPath;

/** * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: WebGrabber.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class WebGrabber extends URLGrabber implements IURLGrabber {


    // Properties


    /**
     * WebGrabber Constructor
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
        $errorCode = array(401, 403, 404, 500, 501);

        if( in_array( $content['http_code'], $errorCode ) || !@$DOM->loadHTML( $content['content'] ) ) {
            return false;
        }
        else {
            $XPath = new DOMXPath( $DOM );
            $info  = array( );
            $info['title'] = strip_tags( trim( @$XPath->query('//title')->item(0)->nodeValue ) );

            if( $info['title'] != '' ) {
                $MXString = new MXString( );
                $info['title'] = $MXString->cropText( $info['title'], 300 );
                $info['url']   = strtolower( $MXString->cropText( $content['url'], 300 ) );
                $info['description'] = '';
                $info['thumbnail'] = array( );
                $metas = $DOM->getElementsByTagName('meta');

                foreach( $metas as $meta ) {
                    if( stristr( $meta->getAttribute('name'), 'description' ) ) {
                        $info['description'] = $meta->getAttribute('content');
                    }
                    if( stristr( $meta->getAttribute('property'), 'og:image' ) ) {
                        $info['thumbnail'][] = $this->rel2abs( $meta->getAttribute('content'), $this->url );
                    }
                }
                if( $info['description'] != '' ) {
                    $info['description'] = strip_tags( $info['description'] );
                    $info['description'] = $MXString->makeLink( $MXString->cropText( $info['description'], 300 ) );
                }
                else {
                    $pTags = $DOM->getElementsByTagName('p');
                    foreach( $pTags as $pTag ) {
                        $nodeValue = strip_tags( $pTag->nodeValue );
                        if( strlen( $nodeValue ) > 150 ) {
                            $info['description'] = $MXString->cropText( $MXString->makeLink( $nodeValue ), 400 );
                            break;
                        }
                    }
                }
                if( sizeof( $info['thumbnail'] ) == 0 ) {
                    // See if any <link rel="image_src" tag
                    $linkTag = $DOM->getElementsByTagName('link');
                    foreach( $linkTag as $link ) {
                        if( $link->getAttribute('rel') == 'image_src' ) {
                            $info['thumbnail'][] = $this->rel2abs( $link->getAttribute('href'), $this->url );
                            break;
                        }
                    }
                }
                if( sizeof( $info['thumbnail'] ) == 0 ) {
                    $images = $DOM->getElementsByTagName('images');
                    foreach( $images as $image ) {
                        $src = $image->getAttribute('src');
                        if( !stristr( $src, 'hqdefault.jpg' ) && !stristr( $src, '__video_encrypted_id__' ) ) {
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
        }
    }


    /**
     * Grab content from URL
     * * @return void
     */
    public function getInfo1( ) {
        $html = file_get_html( $this->url );
        if( !$html ) {
            return false;
        }
        else {
            foreach( $html->find('title') as $element ) {
                $title = strip_tags( $element->plaintext );
            }
            if( $title != '' ) {
                $MXString = new MXString( );
                $info = array( );
                $info['title'] = utf8_decode( $title );
                $info['title'] = $MXString->cropText( $info['title'], 300 );
                $info['title'] = str_replace( 'Incompatible Browser | ', '', $info['title'] );
                $info['url'] = $MXString->cropText( $this->url, 300 );
                $info['description'] = '';

                foreach( $html->find('meta[name=description]') as $element ) {
                    $info['description'] = $element->content;
                }
                if( $info['description'] != '' ) {
                    $info['description'] = utf8_decode( strip_tags( $info['description'] ) );
                    $info['description'] = $MXString->cropText( $info['description'], 300 );
                }
                $info['thumbnail'] = array( );
                foreach( $html->find('images') as $element ) {
                    $src = $element->src;
                    preg_match( '/([^ ?<>#]+\.(?:jpg|png))/Ui', $src, $match );
                    if( isset( $match[1] ) ) {
                        if( !stristr( $src, 'hqdefault.jpg' ) && !stristr( $src, '__video_encrypted_id__' ) ) {
                            if( preg_match( '#^(//)#', $src ) ) {
                                $src = 'http:' . $src;
                            }
                            else {
                                $src = $this->rel2abs( $src, $this->url );
                            }
                            $image = ImageCreateFromString( file_get_contents( $src ) );

                            if( imagesx($image) > 50 && imagesy($image) > 50 ) {
                                $info['thumbnail'][] = $src;
                            }
                            //$info['thumbnail'][] = $src;
                        }
                    }
                }
                return $info;
            }
        }
    }
}
?>