<?php
namespace Markaxis\Leave;
use \Markaxis\Leave\DesignationModel AS M_DesignationModel;
use \Aurora\Admin\AdminView, \Aurora\Component\DesignationModel AS A_DesignationModel;
use \Aurora\Form\SelectGroupListView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: StructureView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StructureView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $StructureModel;
    protected $A_DesignationModel;
    protected $SelectGroupListView;


    /**
    * StructureView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->A_DesignationModel = A_DesignationModel::getInstance( );
        $this->StructureModel = StructureModel::getInstance( );
        $this->SelectGroupListView = new SelectGroupListView( );
        $this->SelectGroupListView->includeBlank( false );
        $this->SelectGroupListView->isMultiple(true);
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAddType( ) {
        $designationList = $this->SelectGroupListView->build('designation', $this->A_DesignationModel->getList( ),
                                                             '','Select Designation' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_DESIGNATION_LIST' => $designationList ) );

        $vars['dynamic']['structure'] = false;
        return $this->View->render( 'markaxis/leave/structureForm.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEditType( $ltID ) {
        $designationList = $this->SelectGroupListView->build('designation', $this->A_DesignationModel->getList( ),
                                                             '','Select Designation' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_DESIGNATION_LIST' => $designationList ) );

        $vars['dynamic']['noGroup'] = false;
        $vars['dynamic']['group'] = false;
        $vars['dynamic']['structure'] = false;

        $M_DesignationModel = M_DesignationModel::getInstance( );
        $groupID = $structureID = 0;

        if( $desigInfo = $M_DesignationModel->getByltID( $ltID ) ) {
            foreach( $desigInfo as $desigGroup ) {
                $child = '';

                if( $strucInfo = $this->StructureModel->getBydesignationID( $desigGroup['ldID'] ) ) {
                    var_dump($strucInfo); exit;
                    $strucVars = array( );

                    foreach( $strucInfo as $structure ) {
                        $strucVars['dynamic']['row'] = array( 'TPLVAR_ID' => $structureID,
                                                              'TPLVAR_LSID' => $structure['lsID'],
                                                              'TPLVAR_START' => $structure['start'],
                                                              'TPLVAR_END' => $structure['end'],
                                                              'TPLVAR_DAYS' => $structure['days'] );


                        $child .= $this->View->render( 'markaxis/leave/structure.tpl', $strucVars );
                        $structureID++;
                    }
                }
                // Group
                $vars['dynamic']['group'][] = array( 'TPLVAR_GID' => $groupID,
                                                     'TPLVAR_GROUP_TITLE' => $desigGroup['designations'],
                                                     'TPL_GROUP_CHILD' => $child );

                $groupID++;
            }
        }
        else {
            $vars['dynamic']['noGroup'] = true;
        }
        return $this->View->render( 'markaxis/leave/structureForm.tpl', $vars );
    }
}
?>