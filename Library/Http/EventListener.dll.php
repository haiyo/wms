<?php
namespace Library\Http;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EventListener.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EventListener extends HttpRequest {


    // Properties
    protected $eventName;
    protected $callback;
                                                                    

    /**
    * EventListener Constructor
    * @return void
    */
    function __construct( $eventName, $callback, $args=NULL ) {
    	parent::HttpRequest( );
        $this->eventName = $eventName;
    	$this->callback  = $callback;
        $this->monitor( $args );
    }


    /**
    * Monitor if source is available & performs a callback
    * G, P, C, F, S from HttpRequest - Whichever comes first
    * @public
    * @return void
    */
    public function monitor( $args=NULL ) {
        foreach( $this->source as $key => $val ) {
            if( isset( $value[$this->eventName] ) ) {
                if( !is_object( $this->callback[0] ) ) {
                    $Object = new $this->callback[0]( );
                    $Object->$this->callback[1]( $args );
                    return $Object;
               	}
                throw( new \Exceptions( 'Undefined method. Unable to perform callback method ' .
                                       $this->callback[1] . ' for class: ' .
                                       get_class( $this->callback[0] ) ) );
            }
        }
    }
}
?>