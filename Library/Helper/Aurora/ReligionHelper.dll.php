<?php
namespace Library\Helper\Aurora;
use \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: ReligionHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ReligionHelper implements IListHelper {


    // Properties


    /**
     * ReligionHelper Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Return List
     * @static
     * @return mixed
     */
    public static function getList( ) {
        return array( );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        return array( '' => '',
                        'Free Thinker' => 'Free Thinker',
                        'Buddhism'   => 'Buddhism',
                        'Christianity'  => 'Christianity',
                        'Islam' => 'Islam',
                        'Hinduism'    => 'Hinduism',
                        'Chinese traditional religion' => 'Chinese traditional religion',
                        'Primal-indigenous' => 'Primal-indigenous',
                        'African traditional and Diasporic' => 'African traditional and Diasporic',
                        'Sikhism' => 'Sikhism',
                        'Juche' => 'Juche',
                        'Spiritism' => 'Spiritism',
                        'Judaism' => 'Judaism',
                        'Bahai' => 'Bahai',
                        'Jainism' => 'Jainism',
                        'Shinto' => 'Shinto',
                        'Cao Dai' => 'Cao Dai' );
    }
}
?>