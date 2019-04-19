<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: DepartmentModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentModel extends \Model {


    // Properties
    protected $Department;


    /**
    * DepartmentModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Department = new Department( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function getList( ) {
        return $this->Department->getList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Department->setLimit( $post['start'], $post['length'] );

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

        $results = $this->Department->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }
}
?>