<?php
namespace Library\Util;
use \Library\Interfaces\IObserver;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IObservable.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
*/

interface IObservable {
    
    /**
    * Provides a custom to check on all Observer classes are valid before notify
    * @return void
    */
    public function addObservers( IObserver $Observer );

    /**
    * Performs Notification to all Observer class
    * @return void
    */
    public function notifyObservers( $action );
}
?>