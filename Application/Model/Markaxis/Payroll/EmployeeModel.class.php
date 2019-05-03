<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: EmployeeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeModel extends \Model {


    // Properties
    protected $Employee;



    /**
     * EmployeeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $this->Employee = new Employee( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getProcessInfo( $userID ) {
        return $this->Employee->getProcessInfo( $userID );
    }
}
?>