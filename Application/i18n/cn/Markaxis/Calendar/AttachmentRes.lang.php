<?php
namespace Markaxis\Calendar;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: AttachmentRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AttachmentRes extends Resource {


    /**
    * AttachmentRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_SELECT_FILES'] = 'Select Files';
        $this->contents['LANG_CLICK_BROWSE'] = 'Attach Files';
        $this->contents['LANG_REMOVE_FILE'] = 'Remove File';
        $this->contents['LANG_DELETE_FILE'] = 'Delete File';
        $this->contents['LANG_BROWSE'] = 'Browse';
        $this->contents['LANG_DRAG_TEXT'] = 'Drag and drop files here';
        $this->contents['LANG_SELECT_FILE_TEXT'] = 'You can select more than one file at a time.';
        $this->contents['LANG_FILE_SIZE_OVER_LIMIT'] = 'The file size is over the 5MB limit.';
        $this->contents['LANG_ATTACHMENTS'] = 'Attachments';
        $this->contents['LANG_FILE_SIZE'] = 'File size';
        $this->contents['LANG_VIEW'] = 'View';
        $this->contents['LANG_DOWNLOAD'] = 'Download';
        $this->contents['LANG_DELETE'] = 'Delete';
        $this->contents['LANG_DELETE_CONFIRM'] = 'This file has already been uploaded. Are you sure you
                                                  want to delete it? This action cannot be undone.';
	}
}
?>