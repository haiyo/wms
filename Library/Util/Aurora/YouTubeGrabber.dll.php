<?php
namespace Aurora;
use \File, \String;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: YouTubeGrabber.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class YouTubeGrabber extends URLGrabber implements IURLGrabber {


    // Properties

    
    /**
    * YouTubeGrabber Constructor
    * @return void
    */
    function __construct( $url ) {
        parent::__construct( $url );
	}


    /**
    * Grab content from YouTube API
    * @return mixed
    */
    public function getInfo( ) {
        preg_match( '/[\\?&]v=([^&#]*)/i', $this->url, $match );
        $param = isset( $match[1] ) ? $match[1] : NULL;

        if( $param == NULL ) {
            return false;
        }
        else {
            $load = @simplexml_load_file( 'http://gdata.youtube.com/feeds/api/videos/' . $param, 'SimpleXMLElement', LIBXML_NOCDATA );
            if( !$load ) return false;

            File::import( LIB . 'Util/MXString.dll.php' );
            $MXString = new MXString( );
            $media  = $load->children('http://search.yahoo.com/mrss/');
            $info   = array( );
            $info['title'] = $MXString->cropText( (string)$media->group->title[0], 300 );
            $info['description'] = $MXString->makeLink( $MXString->cropText( (string)$media->group->description[0], 300 ) );
            $info['url'] = 'http://www.youtube.com/watch?v=' . $param;
            $info['embed'] = 1;
            $info['thumbnail'] = array( );

            $sizeof = sizeof( $media->group->thumbnail );
            for( $i=0; $i<$sizeof; $i++ ) {
                $info['thumbnail'][$i] = (string)$media->group->thumbnail[$i]->attributes( );
            }
            return $info;
        }
	}


    /**
    * Return embed code
    * @return str
    */
    public function getEmbedCode( ) {
        preg_match( '/[\\?&]v=([^&#]*)/i', $this->url, $match );
        $param = isset( $match[1] ) ? $match[1] : NULL;

        if( $param != NULL ) {
            return '<object width="480" height="295">
                    <param name="movie" value="//www.youtube.com/v/' . $param . '?version=3&autoplay=1"></param>
                    <param name="allowFullScreen" value="true"></param>
                    <param name="allowscriptaccess" value="always"></param>
                    <embed src="//www.youtube.com/v/' . $param . '?version=3&autoplay=1" type="application/x-shockwave-flash" width="480" height="295" allowscriptaccess="always" allowfullscreen="true">
                    </embed></object>';
        }
    }
}
?>