<?php
namespace Library\Helper\Markaxis;
use \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: GoogleRegionHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GoogleRegionHelper implements IListHelper {


    // Properties


    /**
    * GoogleRegionHelper Constructor
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
        return array( 'google.com', 'google.co.uk', 'google.com.au', 'google.ca',
                      'google.ad', 'google.ae', 'google.com.af', 'google.com.ag',
                      'google.com.ai', 'google.am', 'google.co.ao', 'google.com.ar',
                      'google.as', 'google.at', 'google.az', 'google.ba',
                      'google.com.bd', 'google.be', 'google.bf', 'google.bg',
                      'google.com.bh', 'google.bi', 'google.bj', 'google.com.bn',
                      'google.com.bo', 'google.com.br', 'google.bs', 'google.co.bw',
                      'google.by', 'google.com.bz', 'google.cd', 'google.cf',
                      'google.cg', 'google.ch', 'google.ci', 'google.co.ck',
                      'google.cl', 'google.cm', 'google.cn', 'google.com.co',
                      'google.co.cr', 'google.com.cu', 'google.cv', 'google.com.cy',
                      'google.cz', 'google.de', 'google.dj', 'google.dk',
                      'google.dm', 'google.com.do', 'google.dz', 'google.com.ec',
                      'google.ee', 'google.com.eg', 'google.es', 'google.com.et',
                      'google.fi', 'google.com.fj', 'google.fm', 'google.fr',
                      'google.ga', 'google.ge', 'google.gg', 'google.com.gh',
                      'google.com.gi', 'google.gl', 'google.gm', 'google.gp',
                      'google.gr', 'google.com.gt', 'google.gy', 'google.com.hk',
                      'google.hn', 'google.hr', 'google.ht', 'google.hu',
                      'google.co.id', 'google.ie', 'google.co.il', 'google.im',
                      'google.co.in', 'google.iq', 'google.is', 'google.it',
                      'google.je', 'google.com.jm', 'google.jo', 'google.co.jp',
                      'google.co.ke', 'google.com.kh', 'google.ki', 'google.kg',
                      'google.co.kr', 'google.com.kw', 'google.kz', 'google.la',
                      'google.com.lb', 'google.li', 'google.lk', 'google.co.ls',
                      'google.lt', 'google.lu', 'google.lv', 'google.com.ly',
                      'google.co.ma', 'google.md', 'google.me', 'google.mg',
                      'google.mk', 'google.ml', 'google.mn', 'google.ms',
                      'google.com.mt', 'google.mu', 'google.mv', 'google.mw',
                      'google.com.mx', 'google.com.my', 'google.co.mz', 'google.com.na',
                      'google.com.ng', 'google.com.ni', 'google.ne', 'google.nl',
                      'google.no', 'google.com.np', 'google.nr', 'google.nu',
                      'google.co.nz', 'google.com.om', 'google.com.pa', 'google.com.pe',
                      'google.com.ph', 'google.com.pk', 'google.pl', 'google.pn',
                      'google.com.pr', 'google.ps', 'google.pt', 'google.com.py',
                      'google.com.qa', 'google.ro', 'google.ru', 'google.rw',
                      'google.com.sa', 'google.com.sb', 'google.sc', 'google.se',
                      'google.com.sg', 'google.sh', 'google.si', 'google.sk',
                      'google.com.sl', 'google.sn', 'google.so', 'google.sm',
                      'google.st', 'google.com.sv', 'google.td', 'google.tg',
                      'google.co.th', 'google.com.tj', 'google.tk', 'google.tl',
                      'google.tm', 'google.tn', 'google.to', 'google.com.tr',
                      'google.tt', 'google.com.tw', 'google.co.tz', 'google.com.ua',
                      'google.co.ug', 'google.com.uy', 'google.co.uz', 'google.com.vc',
                      'google.co.ve', 'google.vg', 'google.co.vi', 'google.com.vn',
                      'google.vu', 'google.ws', 'google.rs', 'google.co.za',
                      'google.co.zm', 'google.co.zw' );
	}
    
    
    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $array = self::getList( );
        $list  = array( );

        foreach( $array as $value ) {
            $list[$value] = $value;
        }
        return $list;
	}
}
?>