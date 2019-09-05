<?php
namespace Markaxis\Leave;
use \Aurora\Component\CountryModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ChildBornModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChildBornModel extends \Model {


    // Properties
    protected $ChildBorn;



    /**
     * ChildBornModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->ChildBorn = new ChildBorn( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        return $this->ChildBorn->isFound( $ltID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getByID( $ltID ) {
        return $this->ChildBorn->getByID( $ltID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['childBorn'] ) && $data['childBorn'] ) {
            $CountryModel = CountryModel::getInstance( );
            $countries = $CountryModel->getList( );

            if( !isset( $countries[$data['childBorn']] ) ) {
                return false;
            }
            $info = array( );
            $info['ltID'] = (int)$data['ltID'];
            $info['cID'] = (int)$data['childBorn'];

            if( $this->isFound( $data['ltID'] ) ) {
                $this->ChildBorn->update('leave_child_born',  $info, 'WHERE ltID = "' . (int)$data['ltID'] . '"');
            }
            else {
                $this->ChildBorn->insert('leave_child_born', $info );
            }
        }
        else {
            $this->ChildBorn->delete('leave_child_born','WHERE ltID = "' . (int)$data['ltID'] . '"');
        }
    }
}
?>