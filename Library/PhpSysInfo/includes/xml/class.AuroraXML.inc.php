<?php
namespace PhpSysInfo;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: class.AuroraXML.inc.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
class AuroraXML extends XML {



    /**
    * AuroraXML Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct();
	}


    /**
    * get the xml object
    * @return string
    */
    public function getXmlInfo( $type ) {
        if (!$this->_plugin_request || $this->_complete_request) {
            if ($this->_sys === null) {
                $this->_sys = $this->_sysinfo->getSys( );
            }
            switch( $type ) {
                case 'vital' :
                $this->_buildVitals( );
                break;

                case 'hardware' :
                $this->_buildHardware( );
                break;

                case 'memory' :
                $this->_buildMemory( );
                break;

                case 'filesystem' :
                $this->_buildFilesystems( );
                break;

                case 'network' :
                $this->_buildNetwork( );
                break;
            }

            //$this->_buildMbinfo();
            //$this->_buildUpsinfo();
        }
        $this->_buildPlugins( );
        $this->_xml->combinexml($this->_errors->errorsAddToXML($this->_sysinfo->getEncoding()));
        return $this->_xml->getSimpleXmlElement();
    }
}
?>