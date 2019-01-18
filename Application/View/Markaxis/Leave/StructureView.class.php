<?php
namespace Markaxis\Leave;
use \Aurora\AuroraView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: StructureView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StructureView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $StructureModel;


    /**
    * StructureView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->StructureModel = StructureModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAddType( ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array(  ) );

        $vars['dynamic']['structure'] = false;
        return $this->render( 'markaxis/leave/structureForm.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderEditType( $ltID ) {
        $vars = array_merge( $this->L10n->getContents( ),
            array(  ) );

        $vars['dynamic']['structure'] = false;

        $id = 0;
        if( $lsInfo = $this->StructureModel->getByID( $ltID ) ) {
            foreach( $lsInfo as $value ) {
                $vars['dynamic']['structure'][] = array( 'TPLVAR_ID' => $id,
                                                        'TPLVAR_LSID' => $value['lsID'],
                                                        'TPLVAR_START' => $value['start'],
                                                        'TPLVAR_END' => $value['end'],
                                                        'TPLVAR_DAYS' => $value['days'] );
                $id++;
            }
        }
        return $this->render( 'markaxis/leave/structureForm.tpl', $vars );
    }
}
?>