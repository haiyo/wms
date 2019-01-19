<?php
namespace Library\Util\Aurora;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 25th, 2012
 * @version $Id: IconDisplay.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IconDisplay {


    // Properties
    private $Registry;
    private $HKEY_LOCAL;
    private $i18n;
    private $iconInfo;
    private $dir;

    // Array of filetype and if 1=viewable on browser;
    private $extIcon = array( 'gif' => array( 'image', 1 ),
                              'png' => array( 'image', 1 ),
                              'jpg' => array( 'image', 1 ),
                              'bmp' => array( 'image', 1 ),
                              'pdf' => array( 'pdf', 1 ),
                              'psd' => array( 'psd', 0 ),
                              'flv' => array( 'flv', 0 ),
                              'fla' => array( 'fla', 0 ),
                              'swf' => array( 'swf', 1 ),
                              '7z'  => array( 'zip', 0 ),
                              'zip' => array( 'zip', 0 ),
                              'gz'  => array( 'zip', 0 ),
                              'tar' => array( 'zip', 0 ),
                              'tgz' => array( 'zip', 0 ),
                              'bz2' => array( 'zip', 0 ),
                              'doc' => array( 'doc', 0 ),
                              'docx' => array( 'doc', 0 ),
                              'xls' => array( 'xls', 0 ),
                              'xlsx' => array( 'xls', 0 ),
                              'pps' => array( 'pps', 0 ),
                              'txt' => array( 'txt', 1 ),
                              'js' => array( 'js', 0 ),
                              'php' => array( 'php', 0 ),
                              'sql' => array( 'sql', 0 ),
                              'css' => array( 'css', 0 ),
                              'htm' => array( 'htm', 1 ),
                              'html' => array( 'html', 1 ),
                              'mp3' => array( 'mp3', 0 ),
                              'xml' => array( 'xml', 1 ),
                              'rss' => array( 'xml', 1 ),
                              'xsl' => array( 'xml', 1 ),
                              'mdb' => array( 'mdb', 0 ) );


    /**
    * IconDisplay Constructor
    * @return void
    */
    function __construct( ) {
        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $this->i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->iconInfo  = array( );
	}


    /**
    * Execute Filter Chain
    * @return void
    */
    public function setThumbnailDir( $dir ) {
        if( !is_dir( $dir ) ) {
            die( 'Thumbnail directory not found!' );
            return false;
        }
        $this->dir = $dir;
    }


    /**
    * Execute Filter Chain
    * @return void
    */
    public function getIcon( $fileInfo ) {
        $ext = strtolower( pathinfo( $fileInfo['hashName'], PATHINFO_EXTENSION ) );

        if( isset( $this->extIcon[$ext] ) ) {
            $this->iconInfo['type'] = $this->extIcon[$ext][0];
            $this->iconInfo['viewable'] = $this->extIcon[$ext][1];
        }
        else {
            $this->iconInfo['type'] = 'unknown';
            $this->iconInfo['viewable'] = 0;
        }
        if( $this->iconInfo['type'] == 'image' && $this->dir ) {
            $hashName = explode( '.', $fileInfo['hashName'] );
            $path = $this->dir . $fileInfo['hashDir'] . '/' . $hashName[0] . '_thumbnail.'  . $hashName[1];

            $this->iconInfo['imagesize'] = getimagesize( $path );
            $this->iconInfo['width']  = $this->iconInfo['imagesize'][0];
            $this->iconInfo['height'] = $this->iconInfo['imagesize'][1];
                    
            // Read image path, convert to base64 encoding
            $imageData = base64_encode( file_get_contents( $path ) );
            // Format the image SRC:  data:{mime};base64,{data};
            $this->iconInfo['icon'] = 'data: ' . mime_content_type( $path ).';base64,'.$imageData;
        }
        else {
            $this->iconInfo['icon'] = ROOT_URL . 'www/themes/aurora/core/images/' .
                                      $this->HKEY_LOCAL['theme'] . '/' .
                                      $this->i18n->getUserLang( ) . '/fileIcon/' .
                                      $this->iconInfo['type'] . '_ico.png';
        }
        /*<?TPLVAR_ROOT_URL?>www/themes/aurora/inbox/images/<?TPLVAR_THEME?>/<?TPLVAR_LANG?>/<?TPLVAR_ICO?>_ico.png*/
        return $this->iconInfo;
    }
}
?>