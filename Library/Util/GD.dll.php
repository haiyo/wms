<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: GD.class.php, v 2.0 Exp $
 */

class GD {



    /**
    * Constructor
    * @returns void
    */
    function __construct( ) {
        //
    }


    /**
    * Resize an image and keep the proportions
    * @return void
    */
    public function resize( $file, $saveAs, $width, $height, $originWidth, $originHeight, $type ) {
        switch( $type ) {
            case IMAGETYPE_GIF:   //   gif -> jpg
            $srcImg = imagecreatefromgif( $file );
            break;
            case IMAGETYPE_JPEG:   //   jpeg -> jpg
            $srcImg = imagecreatefromjpeg( $file );
            break;
            case IMAGETYPE_PNG:  //   png -> jpg
            $srcImg = imagecreatefrompng( $file );
            break;
        }
        $originAspectRatio = $originWidth/$originHeight;
        $targetAspectRatio = $width/$height;

        if( $originAspectRatio > $targetAspectRatio ) {
            $tempHeight = $height;
            $tempWidth = (int)( $height*$originAspectRatio );
        }
        else {
            $tempWidth = $width;
            $tempHeight = (int)( $width/$originAspectRatio );
        }
        // Resize the image into a temporary GD image
        $tempImg = imagecreatetruecolor( $tempWidth, $tempHeight );
        imagecopyresampled( $tempImg, $srcImg, 0, 0, 0, 0, $tempWidth, $tempHeight, $originWidth, $originHeight );

        // Copy cropped region from temporary image into the desired GD image
        $x0 = ( $tempWidth-$width ) / 2;
        $y0 = ( $tempHeight-$height ) / 2;

        $desired_gdim = imagecreatetruecolor( $width, $height );
        imagecopy( $desired_gdim, $tempImg, 0, 0, $x0, $y0, $width, $height );
        imagejpeg( $desired_gdim, $saveAs, 100 );
        imagedestroy( $srcImg );
        imagedestroy( $desired_gdim );
        @chmod( $saveAs, 0755 );
    }
    
    
    /**
    * Rotate an image based on EXIF
    * @return void
    */
    public function rotate( $file, $saveAs, $degree ) {
      	$image = @imagecreatefromjpeg( $file );
      	$image = @imagerotate( $image, $degree, 0 );
      	$success = imagejpeg( $image, $saveAs );
      	// Free up memory (imagedestroy does not delete files):
      	@imagedestroy( $image );
      	return $success;
    }
}
?>