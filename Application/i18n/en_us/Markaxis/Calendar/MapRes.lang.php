<?php
namespace Markaxis\Calendar;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: MapRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MapRes extends Resource {


    /**
    * MapRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_ENTER_ADDRESS'] = 'Enter Address';
        $this->contents['LANG_ADD_LOCATION'] = 'Add Location';
        $this->contents['LANG_MAP_LOCATION'] = 'Map Location';
        $this->contents['LANG_REMOVE_LOCATION'] = 'Remove Location';
        $this->contents['LANG_GET_DIRECTIONS'] = 'Get Directions';
        $this->contents['LANG_ENTER_ADDRESS_DESCRIPT'] = 'Enter an address to add a location.';
        $this->contents['LANG_DETECT_DESCRIPT'] = 'Or <a href="detect" id="detectLocation">click here</a> to automatically detect your current position.';
        $this->contents['LANG_PERMISSION_REQUEST'] = 'Requesting Permission.';
        $this->contents['LANG_PERMISSION_DESCRIPT'] = 'Please click <strong>Allow</strong> on the prompt above to continue...';
        $this->contents['LANG_LOCATION_NOT_FOUND'] = 'Sorry, we were unable to find that address.';
	}
}
?>