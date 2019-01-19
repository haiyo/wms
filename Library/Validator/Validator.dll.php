<?php
namespace Library\Validator;
use \Library\Interfaces\IValidator;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Validator.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
*/

class Validator {


    // Properties
    protected $modules;


    /**
    * Constructor
    * @returns void
    */
    function __construct( ) {
        $this->modules = array( );
    }

    
    /**
    * Add New Module
    * @return void
    */
    public function addModule( $moduleName, IValidator $module ) {
        $this->modules[$moduleName] = $module;
        $this->modules = array_reverse( $this->modules, true ); // Preserve keys
	}


    /**
    * Invoke Object Validation
    * @throws ValidatorException
    * @return true on succeed.
    */
    public function validate( ) {
        foreach( $this->modules as $moduleName => $module ) {
            if( !$module->validate( ) ) {
                throw new ValidatorException( $moduleName );
            }
        }
        return true;
    }
    

    /**
    * htmlspecialchars + trim
    * @return str
    */
    public static function htmlTrim( $string ) {
        return htmlspecialchars( trim( $string ) );
    }
    

    /**
    * strip_tags + trim
    * @return str
    */
    public static function stripTrim( $string ) {
        return strip_tags( trim( $string ) );
    }


    /**
    * Works like PHP function strip_tags, but it only removes selected tags.
    * stripSelectedTags( '<b>Person:</b> <strong>Salavert</strong>', array( 'b', 'strong' ) );
    * @return str
    */
    public function stripSelectedTags( $text, $tags=array( ) ) {
        $args = func_get_args( );
        $text = array_shift( $args );
        $tags = func_num_args( ) > 2 ? array_diff( $args,array( $text ) )  : (array)$tags;

        foreach( $tags as $tag ) {
            if( preg_match_all( '/<'.$tag.'[^>]*>(.*)<\/'.$tag.'>/iU', $text, $found ) ) {
                $text = str_replace( $found[0], $found[1], $text );
            }
        }
        return $text;
    }
}
?>