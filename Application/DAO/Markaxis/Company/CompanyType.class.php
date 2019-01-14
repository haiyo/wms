<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CompanyType.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyType extends \DAO {


    // Properties


    /**
     * CompanyType Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM company_type', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $list = array( );

            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['ctID']] = $row['type'];
            }
        }
        return $list;
    }
}
?>