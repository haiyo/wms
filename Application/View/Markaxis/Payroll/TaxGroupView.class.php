<?php
namespace Markaxis\Payroll;
use \Aurora\AuroraView;
use \Library\IO\File;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxGroupView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGroupView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TaxGroupModel;


    /**
    * TaxGroupView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        File::import( MODEL . 'Markaxis/Payroll/TaxGroupModel.class.php' );
        $TaxGroupModel = TaxGroupModel::getInstance( );
        $this->TaxGroupModel = $TaxGroupModel;

        $this->setJScript( array( ) );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function buildGroupTree( array $elements, $parentID=0 ) {
        $html = '';

        foreach( $elements as $value ) {
            if( $value['parent'] == $parentID ) {
                $children = $this->buildGroupTree( $elements, $value['tgID'] );

                $vars = array( 'TPLVAR_GID' => $value['tgID'],
                               'TPLVAR_GROUP_TITLE' => $value['title'],
                               'TPLVAR_DESCRIPTION' => $value['description'],
                               'TPL_GROUP_CHILD' => $children );

                $vars['TPLVAR_EXPAND_ICON'] = $children ? '' : 'none';

                $html .= $this->render( 'markaxis/payroll/group.tpl', $vars );
            }
        }
        return $html;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderTaxGroup( $tgID ) {
        $elements = array( );

        if( $gInfo = $this->TaxGroupModel->getBytgID( $tgID ) ) {
            $elements[] = $gInfo;
            return $this->buildGroupTree( $elements, $gInfo['parent'] );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderSettings( ) {
        $list = $this->TaxGroupModel->getAll( );
        return $this->buildGroupTree( $list );
    }
}
?>