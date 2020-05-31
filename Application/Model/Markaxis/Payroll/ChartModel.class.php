<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ChartModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChartModel extends \Model {


    // Properties
    protected $Chart;


    /**
     * ChartModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Chart = new Chart( );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getChart( $date ) {
        $from = new \DateTime( $date );
        $to = new \DateTime( $date );
        $to->modify('-11 month');

        $range = array( );
        while( $to<=$from ) {
            array_push($range, $to->format('M Y') );
            $to->modify('+1 month');
        }

        return array( 'range' => $range,
                      'salaries' => $this->Chart->getChart( $date ) );
    }
}
?>