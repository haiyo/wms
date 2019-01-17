<?php
namespace Markaxis\Payroll;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxRuleWrapper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRuleWrapper extends DAO {


    // Properties


    /**
     * TaxRuleWrapper Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getAllTax( $trID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM tax_rule', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
/*
LEFT JOIN tax_computing tc ON ( tc.trID = tr.trID )
                                   LEFT JOIN tax_competency tcc ON ( tcc.trID = tr.trID )
                                   LEFT JOIN tax_designation td ON ( td.trID = tr.trID )
                                   LEFT JOIN tax_contract_type tct ON ( tct.trID = tr.trID )
                                   LEFT JOIN tax_gender tg ON ( tg.trID = tr.trID )
 * */
?>