<?php
namespace Markaxis\Employee;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: ContractModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContractModel extends \Model {


    // Properties
    protected $Contract;


    /**
    * ContractModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Contract = new Contract( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function getList( ) {
        return $this->Contract->getList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Contract->setLimit( $post['start'], $post['length'] );

        $order = 'type';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'type';
                    break;
            }
        }
        $results = $this->Contract->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBycID( $cID ) {
        return $this->Contract->getBycID( $cID );
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $Validator = new Validator( );

        $this->info['cID'] = (int)$data['contractID'];
        $this->info['type'] = Validator::stripTrim( $data['contractTitle'] );
        $this->info['descript'] = Validator::stripTrim( $data['contractDescript'] );

        $Validator->addModule( 'contractTitle', new IsEmpty( $this->info['type'] ) );
        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }
        return true;
    }


    /**
     * Save Pay Item information
     * @return int
     */
    public function save( ) {
        if( !$this->info['cID'] ) {
            unset( $this->info['cID'] );
            $this->info['cID'] = $this->Contract->insert( 'contract', $this->info );
        }
        else {
            $this->Contract->update( 'contract', $this->info, 'WHERE cID = "' . (int)$this->info['cID'] . '"' );
        }
        return $this->info['cID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $data ) {
        $deleted = 0;

        if( is_array( $data['data'] ) ) {
            foreach( $data['data'] as $cID ) {
                $this->Contract->delete('contract', 'WHERE cID = "' . (int)$cID . '"');
                $deleted++;
            }
        }
        return $deleted;
    }
}
?>