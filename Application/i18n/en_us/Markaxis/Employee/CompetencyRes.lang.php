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
        $this->contents['LANG_DELETED_SELECTED_COMPETENCIES'] = 'Delete Selected Competencies';
        $this->contents['LANG_COMPETENCY'] = 'Competency';
        $this->contents['LANG_ENTER_COMPETENCY'] = 'Enter Competency';
        $this->contents['LANG_COMPETENCY_DESCRIPTION'] = 'Competency Description';
        $this->contents['LANG_ENTER_COMPETENCY_DESCRIPTION'] = 'Enter Competency Description';
        $this->contents['LANG_EDIT_COMPETENCY'] = 'Edit Competency';
        $this->contents['LANG_DELETE_COMPETENCY'] = 'Delete Competency';
        $this->contents['LANG_CREATE_NEW_COMPETENCY'] = 'Create New Competency';
        $this->contents['LANG_COMPETENCY_SUCCESSFULLY_CREATED'] = '{competency} has been successfully created!';
        $this->contents['LANG_PLEASE_ENTER_COMPETENCY'] = 'Please enter a Competency';
        $this->contents['LANG_CREATE_ANOTHER_COMPETENCY'] = 'Create Another Competency';
        $this->contents['LANG_NO_COMPETENCY_SELECTED'] = 'No Competency Selected';
        $this->contents['LANG_SEARCH_COMPETENCY'] = 'Search Competency';
        $this->contents['LANG_ARE_YOU_SURE_DELETE_COMPETENCIES'] = 'Are you sure you want to delete the selected competencies?';
    }
}
?>