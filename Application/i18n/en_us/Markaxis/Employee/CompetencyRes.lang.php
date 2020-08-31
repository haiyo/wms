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
        $this->contents['LANG_BULK_ACTION'] = 'Bulk Action';
        $this->contents['LANG_DELETED_SELECTED_COMPETENCIES'] = 'Delete Selected Competencies';
        $this->contents['LANG_COMPETENCY'] = 'Competency';
        $this->contents['LANG_ENTER_COMPETENCY'] = 'Enter Competency';
        $this->contents['LANG_COMPETENCY_DESCRIPTION'] = 'Competency Description';
        $this->contents['LANG_ENTER_COMPETENCY_DESCRIPTION'] = 'Enter Competency Description';
        $this->contents['LANG_DESCRIPTION'] = 'Description';
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'No. of Employee';
        $this->contents['LANG_ACTIONS'] = 'Actions';
        $this->contents['LANG_CANCEL'] = 'Cancel';
        $this->contents['LANG_SUBMIT'] = 'Submit';
    }
}
?>