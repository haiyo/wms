<?php
namespace Library\Util\Aurora;
use \Library\Interfaces\IURLGrabber;
use \Library\Util\MXString;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ViddlerGrabber.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ViddlerGrabber extends URLGrabber implements IURLGrabber {


    // Properties

    
    /**
    * ViddlerGrabber Constructor
    * @return void
    */
    function __construct( $url ) {
        parent::__construct( $url );
	}


    /**
    * Grab content from Viddler API
    * @return mixed
    */
    public function getInfo( ) {
        $load = @simplexml_load_file( 'http://lab.viddler.com/services/oembed/?url=' . $this->url, 'SimpleXMLElement', LIBXML_NOCDATA );
        if( !$load ) return false;

        $MXString = new MXString( );
        $info['title'] = $MXString->cropText( (string)$load->title, 300 );
        $info['description'] = '<a href="' . (string)$load->author_url . '">' . (string)$load->author_name . '</a>';
        $info['url'] = (string)$load->url;
        $info['thumbnail'] = array( );
        $info['thumbnail'][0] = (string)$load->thumbnail_url;
        return $info;
	}


    /**
    * Return embed code
    * @return string
    */
    public function getEmbedCode( ) {
        $load = @simplexml_load_file( 'http://lab.viddler.com/services/oembed/?url=' . $this->url, 'SimpleXMLElement', LIBXML_NOCDATA );
        if( !$load ) return false;

        $url = (string)$load->html->object->param->attributes()->value;

        if( $url ) {
            return '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="437" height="288" id="viddlerplayer-8c4d9d2e">
                    <param name="movie" value="' . $url . '?autoplay=t"/>
                    <param name="allowScriptAccess" value="always"/>
                    <param name="wmode" value="transparent"/>
                    <param name="allowFullScreen" value="true"/>
                    <embed src="' . $url . '?autoplay=t" width="437" height="288" type="application/x-shockwave-flash" wmode="transparent" allowScriptAccess="always" allowFullScreen="true" name="viddlerplayer-8c4d9d2e"/>
                    </object>';
        }
    }
}
?>