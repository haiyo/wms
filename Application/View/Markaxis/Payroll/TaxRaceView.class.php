<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxRaceView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRaceView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TaxRaceModel;


    /**
    * TaxRaceView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/TaxRes');

        $this->TaxRaceModel = TaxRaceModel::getInstance( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderTaxRule( $taxRule ) {
        if( isset( $taxRule['trID'] ) && $raceInfo = $this->TaxRaceModel->getBytrID( $taxRule['trID'] ) ) {
            $criteriaSet = array( );

            foreach( $raceInfo as $race ) {
                array_push($criteriaSet, 'Employee Race: ' . $race['name'] );
            }
            return $criteriaSet;
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function renderAll( $taxRules ) {
        foreach( $taxRules as $key => $taxRule ) {
            $taxRules[$key]['race'] = $this->renderTaxRule( $taxRule );
        }
        return $taxRules;
    }
}
?>