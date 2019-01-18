<?php
namespace Library\Interfaces;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IObserver.dll.php, v 2.0 Exp $
 * @desc Observer Interface Implementation
*/

interface IObserver {

    /**
    * Retrieve notification call from Observable class
    * @return void
    */
    public function init( $sender, $event );
}
?>