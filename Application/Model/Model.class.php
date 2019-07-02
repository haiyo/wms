<?php
use Library\Helper\SingletonHelper;
use \Library\Runtime\Registry;
use \Library\Interfaces\IObserver;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: Model.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

abstract class Model extends SingletonHelper implements IObserver {


    // Properties
    protected $Registry;
    protected $info;
    protected $fileInfo;
    protected $setInfo;
    protected $L10n;
    protected $errMsg;
    protected $observers;


    /**
    * Model Constructor
    * @return void
    */
    function __construct( ) {
        $this->Registry = Registry::getInstance( );
        $this->info = array( );
        $this->observers = array( );
	}


    /**
     * Performs message actions
     * @return void
     */
    public function onChanged( $sender, $action ) {
        $this->$action( $sender );
    }


    /**
    * Get Error Message
    * @return string
    */
    public function getErrMsg( ) {
        return $this->errMsg;
	}


    /**
    * Set Error Message
    * @return void
    */
    public function setErrMsg( $errMsg ) {
        $this->errMsg = $errMsg;
	}


    /**
    * Return Info
    * @return mixed
    */
    public function getInfo( $key='' ) {
        if( $key && isset( $this->info[$key] ) ) {
            return $this->info[$key];
        }
        return $this->info;
	}


    /**
     * Get File Information
     * @return mixed
     */
    public function getFileInfo( ) {
        return $this->fileInfo;
    }


    /**
    * Set Info
    * @return void
    */
    public function setInfo( $info ) {
        $this->info = $info;
    }


    /**
    * Provides a custom to check on all Observer classes are valid before notify
    * @return void
    */
    public function addObservers( IObserver $Observer ) {
        $this->observers[] = $Observer;
    }


    /**
    * Performs Notification to all Observer class
    * @return void
    */
    public function notifyObservers( $action ) {
        $sizeof = sizeof( $this->observers );
        for( $i=0; $i<$sizeof; $i++ ) {
			$this->observers[$i]->onChanged( $this, $action );
		}
    }
}
?>