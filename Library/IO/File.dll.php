<?php
namespace Library\IO;
use \Library\Exception\FileNotFoundException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Thursday, May 17, 2012
 * @version $Id: File.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class File {


    // Properties


    /**
    * Constructor
    * @return void
    */
    function __construct( ) {
        //
    }


    /**
    * Create directory if not exist
    * @return str
    */
    public static function createDir( $dir ) {
        if( !is_dir( $dir ) ) {
            $old_umask = umask(0);
            @mkdir( $dir );
            umask( $old_umask );
        }
    }


    /**
    * Return file content
    * @return str
    */
    public static function read( $filePath ) {
        try {
        	if( !is_file( $filePath ) ) {
        		throw new FileNotFoundException( 'File not found:' . $filePath );
        	}
            return @file_get_contents( $filePath );
        }
        catch( FileNotFoundException $e ) {
            $e->record( );
            return false;
        }
    }

    
    /**
    * Write data to file
    * @return void
    */
    public static function write( $filePath, $data, $flag=0 ) {
        try {
            return @file_put_contents( $filePath, $data, $flag );
        }
        catch( FileNotFoundException $e ) {
            $e->record( );
            return false;
        }
    }


    /**
    * Check if directory is empty
	* @return bool
    */
    public static function dirIsEmpty( $dir ) {
        if( is_dir( $dir ) ) {
            $d = dir( $dir );
            while( $f = $d->read( ) ) {
                if( ( $f != '.' ) && ( $f != '..' ) ) {
                    return false;
                }
            }
        }
        return true;
    }


    /**
    * Remove a directory and all the files in it
    * @empty - Removes the given directory totally, but you can specify to just
    *          "empty" it instead by setting TRUE. In this case it deletes 
    *          everything inside the given directory and keeps the directory itself.
	* @return void
    */
    public static function removeDir( $directory, $empty=false ) {
        // if the path has a slash at the end, remove it
        if( substr( $directory,-1) == '/' ) {
            $directory = substr( $directory, 0, -1 );
        }
        if( !file_exists( $directory ) || !is_dir( $directory ) ) {
            return false;
        }
        else if( !is_readable( $directory ) ) {
            return false;
        }
        else {
            $handle = opendir( $directory );
            while( false !== ( $item = readdir( $handle ) ) ) {
                if( $item != '.' && $item != '..' ) {
                    $path = $directory . '/' . $item;
                    if( is_dir( $path ) ) {
                        self::removeDir( $path );
                    }
                    else {
                        @unlink( $path );
                    }
                }
            }
            closedir( $handle );

            // if the option to empty is not set to true
            if( $empty == false ) {
                if( !@rmdir( $directory ) ) {
                    return false;
                }
            }
            return true;
        }
    }


    /**
    * Import a class or library file once. Surprisingly, tracking what's been
    * already loaded in a static variable is actually 10x+ faster than just
    * calling require_once directly, even when using this extra API method
    * to wrap it.
    * @return void
    */
    public static function import( $file ) {
        static $loaded;
        if( !isset( $loaded[$file] ) ) {
            if( is_readable( $file ) ) {
                require( $file );
                $loaded[$file] = 1;
            }
            else {
                throw( new FileNotFoundException( 'Trying to require ' . $file . ' failed from ' .
                        \Library\Exception\FileNotFoundException::getCaller() . '.' ) );
            }
        }
    }
    
    
    /**
    * Calculate a directory size recursively
    * @return mixed[]
    
    public static function getDirSize( $path ) {

        $total = array( );
        $total['size']      = 0;
        $total['fileCount'] = 0;
        $total['dirCount']  = 0;;

        if( $handle = opendir( $path ) ) {

            while( false !== ( $file = readdir( $handle ) ) ) {
                $nextpath = $path . '/' . $file;
          
                if( $file != '.' && $file != '..' && !is_link ( $nextpath ) ) {
                    if( is_dir( $nextpath ) ) {
                        $total['dirCount']++;
                        $result = self::getDirSize( $nextpath );
                        $total['size']      += $result['size'];
                        $total['fileCount'] += $result['fileCount'];
                        $total['dirCount']  += $result['dirCount'];
                    }
                    else if( is_file( $nextpath ) ) {
                        $total['size'] += filesize( $nextpath );
                        $total['fileCount']++;
                    }
                }
           }
      } 

      closedir( $handle );
      return $total;
    }*/
    
    
    /**
    * Converts human readable file size (e.g. 10 MB, 200.20 GB) into bytes.
    * @return str
    
    public static function formatBytes( $bytes ) {
        if( $bytes < 1024 ) return $bytes.' B';
        else if( $bytes < 1048576 ) return round( $bytes / 1024, 2 ) . ' KB';
        else if( $bytes < 1073741824 ) return round( $bytes / 1048576, 2 ) . ' MB';
        else if( $bytes < 1099511627776 ) return round( $bytes / 1073741824, 2 ) . ' GB';
        else return round( $bytes / 1099511627776, 2 ) . ' TB';
    }*/


    /**
    * Returns file content type
    * @return str
    */
    public static function getType( $filename ) {
        if( function_exists( 'finfo_open' ) && function_exists( 'finfo_file' ) && function_exists( 'finfo_close' ) ) {
			$fileinfo = finfo_open( FILEINFO_MIME );
			$mime_type = finfo_file( $fileinfo, $filename );
			finfo_close( $fileinfo );
			if( !empty( $mime_type ) ) {
				return $mime_type;
			}
		}
        $mime_types = array(
			'ai'      => 'application/postscript',
			'aif'     => 'audio/x-aiff',
			'aifc'    => 'audio/x-aiff',
			'aiff'    => 'audio/x-aiff',
			'asc'     => 'text/plain',
			'asf'     => 'video/x-ms-asf',
			'asx'     => 'video/x-ms-asf',
			'au'      => 'audio/basic',
			'avi'     => 'video/x-msvideo',
			'bcpio'   => 'application/x-bcpio',
			'bin'     => 'application/octet-stream',
			'bmp'     => 'image/bmp',
			'bz2'     => 'application/x-bzip2',
			'cdf'     => 'application/x-netcdf',
			'chrt'    => 'application/x-kchart',
			'class'   => 'application/octet-stream',
			'cpio'    => 'application/x-cpio',
			'cpt'     => 'application/mac-compactpro',
			'csh'     => 'application/x-csh',
			'css'     => 'text/css',
			'dcr'     => 'application/x-director',
			'dir'     => 'application/x-director',
			'djv'     => 'image/vnd.djvu',
			'djvu'    => 'image/vnd.djvu',
			'dll'     => 'application/octet-stream',
			'dms'     => 'application/octet-stream',
			'doc'     => 'application/msword',
            'docx'    => 'application/msword',
			'dvi'     => 'application/x-dvi',
			'dxr'     => 'application/x-director',
			'eps'     => 'application/postscript',
			'etx'     => 'text/x-setext',
			'exe'     => 'application/octet-stream',
			'ez'      => 'application/andrew-inset',
			'flv'     => 'video/x-flv',
			'gif'     => 'image/gif',
			'gtar'    => 'application/x-gtar',
			'gz'      => 'application/x-gzip',
			'hdf'     => 'application/x-hdf',
			'hqx'     => 'application/mac-binhex40',
			'htm'     => 'text/html',
			'html'    => 'text/html',
			'ice'     => 'x-conference/x-cooltalk',
			'ief'     => 'image/ief',
			'iges'    => 'model/iges',
			'igs'     => 'model/iges',
			'images'     => 'application/octet-stream',
			'iso'     => 'application/octet-stream',
			'jad'     => 'text/vnd.sun.j2me.app-descriptor',
			'jar'     => 'application/x-java-archive',
			'jnlp'    => 'application/x-java-jnlp-file',
			'jpe'     => 'image/jpeg',
			'jpeg'    => 'image/jpeg',
			'jpg'     => 'image/jpeg',
			'js'      => 'application/x-javascript',
			'kar'     => 'audio/midi',
			'kil'     => 'application/x-killustrator',
			'kpr'     => 'application/x-kpresenter',
			'kpt'     => 'application/x-kpresenter',
			'ksp'     => 'application/x-kspread',
			'kwd'     => 'application/x-kword',
			'kwt'     => 'application/x-kword',
			'latex'   => 'application/x-latex',
			'lha'     => 'application/octet-stream',
			'lzh'     => 'application/octet-stream',
			'm3u'     => 'audio/x-mpegurl',
			'man'     => 'application/x-troff-man',
			'me'      => 'application/x-troff-me',
			'mesh'    => 'model/mesh',
			'mid'     => 'audio/midi',
			'midi'    => 'audio/midi',
			'mif'     => 'application/vnd.mif',
			'mov'     => 'video/quicktime',
			'movie'   => 'video/x-sgi-movie',
			'mp2'     => 'audio/mpeg',
			'mp3'     => 'audio/mpeg',
			'mpe'     => 'video/mpeg',
			'mpeg'    => 'video/mpeg',
			'mpg'     => 'video/mpeg',
			'mpga'    => 'audio/mpeg',
			'ms'      => 'application/x-troff-ms',
			'msh'     => 'model/mesh',
			'mxu'     => 'video/vnd.mpegurl',
			'nc'      => 'application/x-netcdf',
			'odb'     => 'application/vnd.oasis.opendocument.database',
			'odc'     => 'application/vnd.oasis.opendocument.chart',
			'odf'     => 'application/vnd.oasis.opendocument.formula',
			'odg'     => 'application/vnd.oasis.opendocument.graphics',
			'odi'     => 'application/vnd.oasis.opendocument.image',
			'odm'     => 'application/vnd.oasis.opendocument.text-master',
			'odp'     => 'application/vnd.oasis.opendocument.presentation',
			'ods'     => 'application/vnd.oasis.opendocument.spreadsheet',
			'odt'     => 'application/vnd.oasis.opendocument.text',
			'ogg'     => 'application/ogg',
			'otg'     => 'application/vnd.oasis.opendocument.graphics-template',
			'oth'     => 'application/vnd.oasis.opendocument.text-web',
			'otp'     => 'application/vnd.oasis.opendocument.presentation-template',
			'ots'     => 'application/vnd.oasis.opendocument.spreadsheet-template',
			'ott'     => 'application/vnd.oasis.opendocument.text-template',
			'pbm'     => 'image/x-portable-bitmap',
			'pdb'     => 'chemical/x-pdb',
			'pdf'     => 'application/pdf',
			'pgm'     => 'image/x-portable-graymap',
			'pgn'     => 'application/x-chess-pgn',
			'png'     => 'image/png',
			'pnm'     => 'image/x-portable-anymap',
			'ppm'     => 'image/x-portable-pixmap',
			'ppt'     => 'application/vnd.ms-powerpoint',
			'ps'      => 'application/postscript',
			'qt'      => 'video/quicktime',
			'ra'      => 'audio/x-realaudio',
			'ram'     => 'audio/x-pn-realaudio',
			'ras'     => 'image/x-cmu-raster',
			'rgb'     => 'image/x-rgb',
			'rm'      => 'audio/x-pn-realaudio',
			'roff'    => 'application/x-troff',
			'rpm'     => 'application/x-rpm',
			'rtf'     => 'text/rtf',
			'rtx'     => 'text/richtext',
			'sgm'     => 'text/sgml',
			'sgml'    => 'text/sgml',
			'sh'      => 'application/x-sh',
			'shar'    => 'application/x-shar',
			'silo'    => 'model/mesh',
			'sis'     => 'application/vnd.symbian.install',
			'sit'     => 'application/x-stuffit',
			'skd'     => 'application/x-koan',
			'skm'     => 'application/x-koan',
			'skp'     => 'application/x-koan',
			'skt'     => 'application/x-koan',
			'smi'     => 'application/smil',
			'smil'    => 'application/smil',
			'snd'     => 'audio/basic',
			'so'      => 'application/octet-stream',
			'spl'     => 'application/x-futuresplash',
			'src'     => 'application/x-wais-source',
			'stc'     => 'application/vnd.sun.xml.calc.template',
			'std'     => 'application/vnd.sun.xml.draw.template',
			'sti'     => 'application/vnd.sun.xml.impress.template',
			'stw'     => 'application/vnd.sun.xml.writer.template',
			'sv4cpio' => 'application/x-sv4cpio',
			'sv4crc'  => 'application/x-sv4crc',
			'swf'     => 'application/x-shockwave-flash',
			'sxc'     => 'application/vnd.sun.xml.calc',
			'sxd'     => 'application/vnd.sun.xml.draw',
			'sxg'     => 'application/vnd.sun.xml.writer.global',
			'sxi'     => 'application/vnd.sun.xml.impress',
			'sxm'     => 'application/vnd.sun.xml.math',
			'sxw'     => 'application/vnd.sun.xml.writer',
			't'       => 'application/x-troff',
			'tar'     => 'application/x-tar',
			'tcl'     => 'application/x-tcl',
			'tex'     => 'application/x-tex',
			'texi'    => 'application/x-texinfo',
			'texinfo' => 'application/x-texinfo',
			'tgz'     => 'application/x-gzip',
			'tif'     => 'image/tiff',
			'tiff'    => 'image/tiff',
			'torrent' => 'application/x-bittorrent',
			'tr'      => 'application/x-troff',
			'tsv'     => 'text/tab-separated-values',
			'txt'     => 'text/plain',
			'ustar'   => 'application/x-ustar',
			'vcd'     => 'application/x-cdlink',
			'vrml'    => 'model/vrml',
			'wav'     => 'audio/x-wav',
			'wax'     => 'audio/x-ms-wax',
			'wbmp'    => 'image/vnd.wap.wbmp',
			'wbxml'   => 'application/vnd.wap.wbxml',
			'wm'      => 'video/x-ms-wm',
			'wma'     => 'audio/x-ms-wma',
			'wml'     => 'text/vnd.wap.wml',
			'wmlc'    => 'application/vnd.wap.wmlc',
			'wmls'    => 'text/vnd.wap.wmlscript',
			'wmlsc'   => 'application/vnd.wap.wmlscriptc',
			'wmv'     => 'video/x-ms-wmv',
			'wmx'     => 'video/x-ms-wmx',
			'wrl'     => 'model/vrml',
			'wvx'     => 'video/x-ms-wvx',
			'xbm'     => 'image/x-xbitmap',
			'xht'     => 'application/xhtml+xml',
			'xhtml'   => 'application/xhtml+xml',
			'xls'     => 'application/vnd.ms-excel',
			'xml'     => 'text/xml',
			'xpm'     => 'image/x-xpixmap',
			'xsl'     => 'text/xml',
			'xwd'     => 'image/x-xwindowdump',
			'xyz'     => 'chemical/x-xyz',
			'zip'     => 'application/zip'
		);

		$ext = strtolower( array_pop( explode( '.', $filename ) ) );
		if( ! empty( $mime_types[$ext] ) ) {
			return $mime_types[$ext];
		}
		return 'application/octet-stream';
    }
}
?>