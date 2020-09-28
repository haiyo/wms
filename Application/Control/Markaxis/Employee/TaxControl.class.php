<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxControl {


    // Properties
    protected $TaxModel;


    /**
     * TaxControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxModel = TaxModel::getInstance( );
    }
}
?>