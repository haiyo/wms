<?php
namespace Aurora\Component;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CityControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CityControl {


    // Properties


    /**
     * CityControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function cityList( ) {
        $post = Control::getRequest( )->request( POST );

        File::import( MODEL . 'Aurora/Component/CityModel.class.php' );
        $CityModel = CityModel::getInstance( );
        echo json_encode( $CityModel->getList( $post ) );
        exit;
    }
}
?>