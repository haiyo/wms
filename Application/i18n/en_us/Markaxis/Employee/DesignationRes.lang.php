<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DesignationRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationRes extends Resource {


    // Properties


    /**
     * DesignationRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_CREATE_NEW_DESIGNATION'] = 'Create New Designation';
        $this->contents['LANG_CREATE_NEW_DESIGNATION_GROUP'] = 'Create New Designation Group';
    }
}
?>