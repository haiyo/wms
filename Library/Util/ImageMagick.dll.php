<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ImageMagick.class.php, v 2.0 Exp $
 */

class ImageMagick {


    protected $imPath;


    /**
    * Constructor
	* @return void
    */
    function __construct( ) {
        //$this->imPath = exec( 'whereis convert' );
        $this->imPath = '';
    }


    /**
    * Return ImageMagick installation path
	* @return void
    */
    function getPath( ) {
        return $this->imPath;
    }


    /**
    * Resize an image using IM
	* @return void
    */
    public function resize( $file, $saveAs, $width, $height ) {
        $cmd = $this->imPath . 'convert "' . $file . '" -resize "' . $width . 'x' . $height . '^" -gravity center -crop ' . $width . 'x' . $height . '+0+0 +repage "' . $saveAs . '"';
        `$cmd`;
    }


    /**
    * Resize an image and keep the proportions
    * @public
	* @return void
    */
    public function IMFlip( $file, $saveAs ) {
        $cmd = $this->imPath . 'convert "' . $file . '" -flip "' . $saveAs . '"';
        `$cmd`;
    }

    
    /**
    * Resize an image and keep the proportions
    * @public
	* @return void
    */
    public function IMFlop( $file, $saveAs ) {
        $cmd = $this->imPath . 'convert "' . $file . '" -flop "' . $saveAs . '"';
        `$cmd`;
    }


    /**
    * Resize an image and keep the proportions
    * @public
	* @return void
    */
    public function IMResizeCrop( $file, $saveAs, $resizeWidth, $resizeHeight, $cropWidth, $cropHeight ) {
        $cmd = $this->imPath . 'convert "' . $file . '" ' .
                  '-resize ' . $resizeWidth . 'x -resize "x' . $resizeHeight . '<"   -resize 50% ' .
                  '-gravity center -crop ' . $cropWidth . 'x' . $cropHeight . '+0+0 +repage "' . $saveAs . '"';
        `$cmd`;
    }


    /**
    * Resize an image and keep the proportions
    * @public
	* @return void
    */
    public function IMCrop( $file, $saveAs, $cropWidth, $cropHeight, $cropX, $cropY ) {
        $cmd = $this->imPath . 'convert "' . $file . '" ' .
                  '-crop ' . $cropWidth . 'x' . $cropHeight . '+' . $cropX . '+' . $cropY . ' +repage "' . $saveAs . '"';
        `$cmd`;
    }


    /**
    * Resize an image and keep the proportions
    * @public
	* @return void
    */
    public function IMRotate( $file, $saveAs, $degree ) {
        $cmd = $this->imPath . 'convert "' . $file . '" -rotate ' . $degree . ' "' . $saveAs . '"';
        `$cmd`;
    }
}
?>