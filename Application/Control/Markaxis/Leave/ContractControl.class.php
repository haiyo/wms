<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ContractControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContractControl {


    // Properties
    protected $ContractModel;


    /**
     * ContractControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ContractModel = ContractModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function globalInit( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['leaveTypes'] ) && is_array( $data['leaveTypes'] ) && sizeof( $data['leaveTypes'] ) > 0 ) {
            Control::setOutputArray( array( 'leaveTypes' => $this->ContractModel->getByGroups( $data['leaveTypes'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getGroup( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['group'] ) ) {
            Control::setOutputArrayAppend( array( 'contract' => $this->ContractModel->getBylgID( $data['group']['lgID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveType( ) {
        $post = Control::getPostData( );

        $ContractModel = ContractModel::getInstance( );
        $ContractModel->save( $post );
        Control::setPostData( $post );
    }
}
?>