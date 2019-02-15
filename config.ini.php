<?php
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: config.ini.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

//error_reporting(E_PARSE | E_NOTICE | E_DEPRECATED);

define( 'DBTYPE',  'MySQLii'   );
define( 'DBHOST',  '127.0.0.1' );
define( 'DBUSER',  'root'      );
define( 'DBPASS',  'abcdef'    );
define( 'DBNAME',  'aurora'    );
define( 'DBPORT',  '3306'      );

define( 'SEP',  DIRECTORY_SEPARATOR     );
define( 'ROOT', dirname(__FILE__) . SEP );

define( 'APP',  ROOT . 'Application/' );
define( 'TPL',  ROOT . 'www/themes/'  );

// Path to store log file.
define( 'LOG_DIR', ROOT . 'log/' );

// Path to upload directory.
define( 'UPLOAD_DIR', ROOT . 'www/mars/' );

define( 'USER_DIR', UPLOAD_DIR . 'user/' );
define( 'USER_PHOTO_DIR', USER_DIR . 'photo/' );
define( 'USER_EDU_DIR', USER_DIR . 'edu/' );
define( 'USER_EXP_DIR', USER_DIR . 'exp/' );

define( 'LOGO_DIR', UPLOAD_DIR . 'logo/' );
define( 'BACKUP_DIR', UPLOAD_DIR . 'backup/' );

// Implementation Directories
define( 'CONTROL', APP . 'Control/' );
define( 'MODEL',   APP . 'Model/'   );
define( 'VIEW',    APP . 'View/'    );
define( 'DAO',     APP . 'DAO/'     );
define( 'PLUGINS', APP . 'Plugins/' );
define( 'LANG',    APP . 'i18n/'    );
define( 'XML',     APP . 'xml/'     );

// System Library Directories
define( 'LIB',  ROOT . 'Library/'    );
define( 'EXC',  LIB  . 'Exception/'  );
define( 'INT',  LIB  . 'Interfaces/' );
define( 'HLP',  LIB  . 'Helper/'     );

define( 'AURORA_VERSION', 'Aurora Core 2.0' );