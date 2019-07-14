<?php
namespace Markaxis\Payroll;
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
     * Get File Information
     * @return mixed
     */
    public function getList( $selectable=false ) {
        return $this->TaxGroup->getList( $selectable );
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
}
?>