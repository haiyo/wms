<?php
namespace Markaxis\Payroll;
use \Aurora\Component\OfficeModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxGroupModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGroupModel extends \Model {


    // Properties
    protected $TaxGroup;
    private static $groupList = array( );



    /**
     * TaxGroupModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/TaxRes');

        $this->TaxGroup = new TaxGroup( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $tgID ) {
        return $this->TaxGroup->isFound( $tgID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getAll( ) {
        return $this->TaxGroup->getAll( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBytgID( $tgID ) {
        return $this->TaxGroup->getBytgID( $tgID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByParentTgID( $parentTgID ) {
        return $this->TaxGroup->getByParentTgID( $parentTgID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getList( $selectable=false ) {
        return $this->TaxGroup->getList( $selectable );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getListByOfficeID( $oID ) {
        return $this->TaxGroup->getListByOfficeID( $oID );
    }


    /**
     * Build select list with tree structure.
     * @return mixed
     */
    public function getSelectList( ) {
        return $this->buildSelectList( $this->TaxGroup->getSelectList( ) );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function buildSelectList( array $elements=array(), $parentID=0, $level=0 ) {
        $branch = array( );

        foreach( $elements as $element ) {
            if( $element['parent'] == $parentID ) {
                $element['level'] = $level+1;
                $branch[] = $element;

                if( $element['tgID'] == 0 ) continue;

                $children = $this->buildSelectList( $elements, $element['tgID'], $level+1 );

                if( $children ) {
                    if( isset( $children['tgID'] ) ) {
                        $children['level'] = $level;
                    }
                    $element['children'] = $children;
                }

                if( isset( $element['children'] ) ) {
                    foreach( $element['children'] as $child ) {
                        $child['text'] = '-- ' . $child['text'];
                        $branch[] = $child;
                    }
                    unset( $element['children'] );
                }
            }
        }
        return $branch;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function saveTaxGroup( $data ) {
        $this->info['title'] = Validator::stripTrim( $data['groupTitle'] );
        $this->info['descript'] = Validator::stripTrim( $data['groupDescription'] );
        $this->info['parent'] = (int)$data['parent'];

        if( $this->info['parent'] && !$this->isFound( $this->info['parent'] ) ) {
            $this->info['parent'] = 0;
        }

        $OfficeModel = OfficeModel::getInstance( );

        if( $data['office'] && $OfficeModel->isFound( $data['office'] ) ) {
            $this->info['officeID'] = (int)$data['office'];
        }

        $this->info['selectable']  = ( isset( $data['selectable']  ) && $data['selectable']  ) ? 1 : 0;
        $this->info['summary'] = ( isset( $data['summary'] ) && $data['summary'] ) ? 1 : 0;

        if( $data['tgID'] && $this->isFound( $data['tgID'] ) ) {
            $this->info['tgID'] = (int)$data['tgID'];
            $this->TaxGroup->update( 'tax_group', $this->info, 'WHERE tgID = "' . (int)$this->info['tgID'] . '"' );
        }
        else {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['tgID'] = $this->TaxGroup->insert('tax_group', $this->info );
        }
        return $this->info['tgID'];
    }


    /**
     * Delete Pay Item
     * @return mixed
     */
    public function delete( $tgID ) {
        array_push(self::$groupList, $tgID );

        $info = array( );
        $info['deleted'] = 1;
        $this->TaxGroup->update( 'tax_group', $info, 'WHERE tgID = "' . (int)$tgID . '"' );

        $list = $this->getByParentTgID( $tgID );

        if( sizeof( $list ) > 0 ) {
            foreach( $list as $row ) {
                $this->delete( $row['tgID'] );
            }

        }
        return self::$groupList;
    }
}
?>