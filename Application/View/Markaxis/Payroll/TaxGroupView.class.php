<?php
namespace Markaxis\Payroll;
use \Aurora\Admin\AdminView;
use \Library\Util\MXString;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxGroupView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGroupView {


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
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxGroupModel = TaxGroupModel::getInstance( );

        $this->View->setJScript( array( ) );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function buildGroupTree( array $elements, $parentID=0 ) {
        $html = '';

        $MXString = new MXString( );

        foreach( $elements as $value ) {
            if( $value['parent'] == $parentID ) {
                $children = $this->buildGroupTree( $elements, $value['tgID'] );

                $vars = array( 'TPLVAR_GID' => $value['tgID'],
                               'TPLVAR_GROUP_TITLE' => $value['title'],
                               'TPLVAR_DESCRIPTION' => $MXString->makeLink( $value['descript'] ),
                               'TPL_GROUP_CHILD' => $children );

                $html .= $this->View->render( 'markaxis/payroll/group.tpl', $vars );
            }
        }
        return $html;
    }


    /**
     * Render main navigation
     * @return string
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
     * @return string
     */
    public function renderSettings( ) {
        $list = $this->TaxGroupModel->getAll( );
        return $this->buildGroupTree( $list );
    }
}
?>