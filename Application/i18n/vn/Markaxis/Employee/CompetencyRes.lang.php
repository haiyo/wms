<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CompetencyRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyRes extends Resource {


    // Properties


    /**
     * CompetencyRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_COMPETENCY'] = 'Competency';
        $this->contents['LANG_CREATE_NEW_COMPETENCY'] = 'Create New Competency';
    }
}
?>