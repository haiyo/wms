<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserItemModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserItemModel extends \Model {


    // Properties
    protected $UserItem;


    /**
     * UserItemModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->UserItem = new UserItem( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getUserItem( $userID, $piID ) {
        return $this->UserItem->getUserItem( $userID, $piID );
    }
}