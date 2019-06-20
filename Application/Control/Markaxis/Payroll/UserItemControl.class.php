<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserItemControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserItemControl {


    // Properties
    protected $UserItemModel;
    protected $UserItemView;


    /**
     * UserItemControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->UserItemModel = UserItemModel::getInstance( );
        $this->UserItemView = new UserItemView( );
    }
}
?>