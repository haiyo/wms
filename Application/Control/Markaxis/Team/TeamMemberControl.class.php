<?php
namespace Markaxis\Team;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TeamMemberControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TeamMemberControl {


    // Properties
    protected $TeamMemberModel;


    /**
     * TeamControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TeamMemberModel = TeamMemberModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function create( ) {
        $post = Control::getPostData( );

        $post['eID'] = $this->TeamMemberModel->create( $post );
        Control::setPostData( $post );
    }
}
?>