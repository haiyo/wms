<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: RecruitSourceModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RecruitSourceModel extends \Model {


    // Properties
    protected $RecruitSource;


    /**
     * RecruitSourceModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();

        $this->RecruitSource = new RecruitSource( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $rsID ) {
        return $this->RecruitSource->isFound( $rsID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->RecruitSource->getList( );
    }
}
?>