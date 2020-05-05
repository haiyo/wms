<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: HolidayModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HolidayModel extends \Model {


    // Properties
    protected $Holiday;


    /**
     * HolidayModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Holiday = new Holiday( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getAll( ) {
        return $this->Holiday->getAll( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Holiday->setLimit( $post['start'], $post['length'] );

        $order = 'h.date';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'h.title';
                    break;
                case 2:
                    $order = 'h.date';
                    break;
            }
        }
        $results = $this->Holiday->getResults( $post['search']['value'], $order . $dir );
        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }
}
?>