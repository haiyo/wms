<?php
namespace Markaxis\Leave;
use \Library\Helper\Aurora\YesNoHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: HaveChildModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HaveChildModel extends \Model {


    // Properties
    protected $HaveChild;



    /**
     * HaveChildModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->HaveChild = new HaveChild( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->HaveChild->isFound( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $ltID ) {
        return $this->HaveChild->getByID( $ltID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['haveChild'] ) ) {
            if( !isset( YesNoHelper::getL10nList( )[$data['haveChild']] ) ) {
                return false;
            }
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];
            $info['haveChild'] = (int)$data['haveChild'];

            if( $this->isFound( $data['ltID'] ) ) {
                $this->HaveChild->update('leave_have_child', $info, 'WHERE ltID = "' . (int)$data['ltID'] . '"');
            }
            else {
                $this->HaveChild->insert('leave_have_child', $info );
            }
        }
    }
}
?>