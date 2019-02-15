<?php
namespace Markaxis\Team;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TeamControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TeamControl {


    // Properties
    protected $TeamModel;
    protected $EmployeeView;


    /**
     * TeamControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TeamModel = TeamModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function create( ) {
        $post = Control::getRequest( )->request( POST, 'data' );

        $post['tID'] = $this->TeamModel->create( $post );
        Control::setPostData( $post );
    }
}
?>