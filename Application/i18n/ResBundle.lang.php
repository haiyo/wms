<?php
use \Library\IO\File;
use \Library\Exception\FileNotFoundException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: ResBundle.lang.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

abstract class ResBundle {


    // Properties
    protected $contents;
    protected $rules;


    /**
    * Return Rules
    * @return mixed
    */
    public function getRules( $key=NULL ) {
        if( !is_null( $key ) && isset( $this->rules[$key] ) ) {
            return $this->rules[$key];
        }
        else {
            return $this->rules;
        }
	}

    
    /**
    * Return Language Content
    * @return mixed
    */
    public function getContents( $key=NULL ) {
        if( !is_null( $key ) && isset( $this->contents[$key] ) ) {
            return $this->contents[$key];
        }
        else {
            return $this->contents;
        }
	}


    /**
    * Replace a string with dynamic vars.
    * @return str
    */
    public function strReplace( $search, $replace, $key ) {
        if( isset( $this->contents[$key] ) ) {
            $this->contents[$key] = str_replace( '{' . $search . '}', $replace, $this->contents[$key] );
            return $this->contents[$key];
        }
        // If can't find from contents, could be coming from Resource.
        return str_replace( '{' . $search . '}', $replace, $key );
	}


    /**
    * Retrieve text based on plural rules
    * @return str
    */
    public function getText( $key, $apply, $replace='', $rules='' ) {
        if( isset( $this->contents[$key] ) ) {
            if( !is_array( $rules ) ) {
                $rules = $this->rules['choice'];
            }
            // Note: Don't use the above strReplace method because we don't want our key
            // to be overwritten as other class may use it.
            //$string = str_replace( '{n}', $replace, $this->contents[$key] );
            $string = $this->contents[$key];

            //$t = preg_match_all( '/(.*)(\d+)\s+(.*)/', $string, $match );
            $t = preg_match_all( '/(.*)({n}+)\s+(.*)/', $string, $match );
            //if( $t === 0 ) return $string;

            $frontText = $match[1][0] . $match[2][0] . ' ';
            $backText  = preg_match_all( '/\s+(.*)/', $match[3][0], $back );

            if( isset( $back[0][0] ) ) {
                $backText = $back[0][0];
                $match[3][0] = str_replace( $backText, '', $match[3][0] );
            }
            else {
                $backText = '';
            }
            $replace = $replace ? $replace : $apply;
            $t = explode( '|', $match[3][0] );
            $i = 0;
            if( sizeof( $t ) > 0 ) {
                foreach( $rules as $rule ) {
                    $choice = $this->strReplace( 'n', $apply, $rule );
                    if( @eval("return $choice;") && isset( $t[$i] ) ) {
                        return str_replace( '{n}', $replace, $frontText . $t[$i] . $backText );
                    }
                    $i++;
                }
            }
            // Otherwise~
            return str_replace( '{n}', $replace, $frontText . $t[(sizeof($t)-1)] . $backText );
        }
	}


    /**
    * Generate contents to JavaScript and return the cache file name
    * @return str
    */
    public function getL10n( ) {
        $locale = ROOT . 'www/themes/default/assets/js/locale/';
        list( $dirname, $filename ) = explode( '\\', get_class( $this ) );
        $filename = $filename . '.js';
        $hash = MD5( serialize( $this->contents ) );

        try {
            $cacheHash = str_replace( array('var hash="', '";', "\n" ), '', File::read( $locale . $dirname . '/' . $filename ) );
            $cacheHash = substr( $cacheHash, 0, 32 );

            if( $cacheHash != $hash ) {
                // Cache expired, refresh cache with new content.
                throw new FileNotFoundException(NULL);
            }
        }
        catch( FileNotFoundException $e ) {
            File::createDir( $locale . $dirname );
            File::write( $locale . $dirname . '/' . $filename, $this->genJS( $hash, $dirname, $filename ) );
        }
        return $dirname . '/' . $filename;
	}


    /**
    * Generate contents to JavaScript
    * NOTE: Before using this to output JS, make sure you've already created your
    * own namespace in a JS file!
    * @return str
    */
    private function genJS( $hash, $dirname, $filename ) {
        $info = pathinfo( $filename );
        $name = $info['filename'];

        $js = 'var hash="' . $hash . "\";\n" .
              'function ' . $dirname .  $name . "(){}\n" .
            $dirname . '.i18n.' . $name . ' = {';

        foreach( $this->contents as $key => $value ) {
            $value = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $value );
            $value = preg_replace( '/\s\s+/', ' ', $value );
            $js .= $key . ' : "' . htmlspecialchars( $value ) . '",';
        }
        $js .= '};';
        return $js;
    }
}
?>