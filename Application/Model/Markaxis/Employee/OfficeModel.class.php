<?php
namespace Markaxis\Employee;
use \Aurora\User\UserImageModel;
use \Aurora\Component\DepartmentModel AS A_DepartmentModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: OfficeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeModel extends \Model {


    // Properties
    protected $Office;



    /**
     * DepartmentModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Office = new Office( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getCountList( $oID ) {
        $list = $this->Office->getCountList( $oID );

        if( sizeof( $list ) > 0 ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $list as $key => $value ) {
                $list[$key]['image'] = $UserImageModel->getImgLinkByUserID( $list[$key]['userID'] );
            }
        }
        return $list;
    }
}
?>