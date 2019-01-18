<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ImageManipulation.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ImageManipulation {


    // Properties
    private $engine;


    /**
    * Constructor
    * @return void
    */
    function __construct( $engine ) {
        $this->engine = $engine == 'im' ? 'im' : 'gd';
    }


    /**
    * Calculate proportion sizes
    * @return mixed
    */
    protected function getProportion( $originWidth, $originHeight, $maxWidth, $maxHeight ) {
        // Calculate height
        if( $maxHeight && $originHeight > $maxHeight ) {
            $originWidth  = ( $maxHeight / $originHeight ) * $originWidth;
            $originHeight = $maxHeight;
        }
        // Calculate width
        if( $maxWidth && $originWidth > $maxWidth ) {
            $originHeight = ( $maxWidth / $originWidth ) * $originHeight;
            $originWidth  = $maxWidth;
        }
        return array( $originWidth, $originHeight );
    }


    /**
    * Copy file and resize
    * @returns void
    */
    public function copyResized( $file, $saveAs, $maxWidth='', $maxHeight='', $proportion=true ) {
        list( $originWidth, $originHeight, $type ) = getimagesize( $file );
        
        if( $proportion ) {
            $size = $this->getProportion( $originWidth, $originHeight, $maxWidth, $maxHeight );
            $width  = $size[0];
            $height = $size[1];
        }
        else {
            $width  = $maxWidth;
            $height = $maxHeight;
        }
        if( $this->engine == 'gd' ) {
            File::import( LIB . 'Util/GD.dll.php' );
            $GD = new GD( );
            $GD->resize( $file, $saveAs, $width, $height, $originWidth, $originHeight, $type );
        }
        else if( $this->engine == 'im' ) {
            File::import( LIB . 'Util/ImageMagick.dll.php' );
            $ImageMagick = new ImageMagick( );
            $ImageMagick->resize( $file, $saveAs, $width, $height );
        }
    }


    /**
    * Rotate image
    * @returns void
    */
    public function autoRotate( $file, $saveAs='' ) {
        $exif = @exif_read_data( $file );
        if( $exif === false ) {
            return false;
        }
      	$orientation  = (int)@$exif['Orientation'];
        $acceptOrient = array( 3 => 180, 6 => 270, 8 => 90 );
        
        if( isset( $acceptOrient[$orientation] ) ) {
            $saveAs = $saveAs ? $saveAs : $file;
            
            if( $this->engine == 'gd' ) {
                File::import( LIB . 'Util/GD.dll.php' );
                $GD = new GD( );
                $GD->rotate( $file, $saveAs, $acceptOrient[$orientation] );
            }
        }
    }
}
?>