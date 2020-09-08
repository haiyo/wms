<?php
namespace Markaxis\Leave;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ManagerRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagerRes extends Resource {


    // Properties


    /**
     * ManagerRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_LEAVE_PENDING_APPROVAL'] = '<?TPLVAR_FNAME?> <?TPLVAR_LNAME?>\'s leave request
                                                          is pending your approval.';
    }
}
?>