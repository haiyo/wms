<?php
namespace Markaxis\Company;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: CompanyTypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeModel extends \Model {


    // Properties
    protected $Offce;


    /**
    * CompanyTypeModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        File::import( DAO . 'Markaxis/Company/Office.class.php' );
        $this->Office = new Office( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function getList( ) {
        return $this->Office->getList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Office->setLimit( $post['start'], $post['length'] );

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'name';
                    break;
                case 2:
                    $order = 'address';
                    break;
                case 3:
                    $order = 'country';
                    break;
                case 4:
                    $order = 'staff';
                    break;
            }
        }

        $results = $this->Office->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }
}
?>