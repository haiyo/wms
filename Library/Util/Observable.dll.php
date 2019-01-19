<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Observable.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
*/


// NOTE: THIS CLASS HAS BEEN DEPRECATED FOR THE TIME BEING AS
//       I COULDN'T REALLY SEE A REASON FOR IT.



class Observable implements IObservable {


    // Properties
    protected $Observable;
    protected $container;


    /**
    * Constructor
    * @return void
    */
    function __construct( $Observable ) {
        $this->Observable = $Observable;
        $this->container  = array( );
    }


    /**
    * Adds an observer to the internal list of observers.
    * @return void
    */
    public function addObservers( IObserver $Observer ) {
        $this->container[get_class($Observer)] = $Observer;
    }


    /**
    * Deletes an observer from the internal list of observers.
    * @return void
    */
    public function deleteObserver( $ObserverName ) {
        if( isset( $this->container[$ObserverName]) ) {
            unset( $this->container[$ObserverName] );
        }
    }


    /**
    * Returns the number of observers in the internal list of observers.
    * @return int
    */
    public function countObservers( ) {
        return sizeof( $this->container );
    }


    /**
    * Performs Notification to all Observer class
    * @return void
    */
    public function notifyObservers( $action ) {
        foreach( $this->container as $Observer ) {
            $Observer->update( $this->Observable );
        }
    }
}
?>