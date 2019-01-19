<?php
namespace Library\Util\Aurora;
use \Library\Interfaces\IURLGrabber;
use \Library\Util\MXString;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: VimeoGrabber.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class VimeoGrabber extends URLGrabber implements IURLGrabber {


    // Properties

    
    /**
    * VimeoGrabber Constructor
    * @return void
    */
    function __construct( $url ) {
        parent::__construct( $url );
	}


    /**
    * Grab content from Vimeo API
    * @return mixed
    */
    public function getInfo( ) {
        $load = simplexml_load_file( 'http://www.vimeo.com/api/oembed.xml?url=' . $this->url . '&maxwidth=300', 'SimpleXMLElement', LIBXML_NOCDATA );
        if( !$load ) return false;

        $MXString = new MXString( );
        $info['title'] = $MXString->cropText( (string)$load->title, 300 );
        $info['description'] = nl2br( $MXString->cropText( (string)$load->description, 300 ) );
        $info['url'] = 'http://vimeo.com/' . (string)$load->video_id;
        $info['thumbnail'] = array( );
        $info['thumbnail'][0] = (string)$load->thumbnail_url;
        $info['embed'] = 1;
        return $info;
	}


    /**
    * Return embed code
    * @return str
    */
    public function getEmbedCode( ) {
        return '<iframe src="http://player.vimeo.com/video/16850588?autoplay=1" width="800" height="450" frameborder="0"></iframe>';
    }
}
?>