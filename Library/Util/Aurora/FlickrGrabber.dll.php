<?php
namespace Library\Util\Aurora;
use \Library\Interfaces\IURLGrabber;
use \Library\Util\MXString;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: FlickrGrabber.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FlickrGrabber extends URLGrabber implements IURLGrabber {


    // Properties

    
    /**
    * FlickrGrabber Constructor
    * @return void
    */
    function __construct( $url ) {
        parent::__construct( $url );
	}


    /**
    * Grab content from Flickr API
    * @return mixed
    */
    public function getInfo( ) {
        $load = @simplexml_load_file( 'http://flickr.com/services/oembed?url=' . $this->url . '&maxwidth=120&maxheight=90', 'SimpleXMLElement', LIBXML_NOCDATA );
        if( !$load ) return false;

        $MXString = new MXString( );
        $info['title'] = $MXString->cropText( (string)$load->title, 300 );
        $info['description'] = '<a href="' . (string)$load->author_url . '">' . (string)$load->author_name . '</a>';
        $info['url'] = (string)$load->author_url;
        $info['thumbnail'] = array( );
        $info['thumbnail'][0] = (string)$load->url;
        return $info;
	}
}
?>