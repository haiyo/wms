<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DepartmentRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentRes extends Resource {


    // Properties


    /**
     * DepartmentRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_DEPARTMENT'] = 'Department';
        $this->contents['LANG_CREATE_NEW_DEPARTMENT'] = 'Create New Department';
    }
}
?>