<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IListHelper.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

interface IListHelper {


    /**
    * Return List
    * @static
    * @return mixed
    */
    public static function getList( );


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( );
}
?>