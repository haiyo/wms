<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Friday, July 27, 2012
 * @version $Id: MXString.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MXString {


    private $maxLengthURL;


    /**
    * String Constructor
    * @return void
    */
    function __construct( ) {
        //
    }
    
    
    /**
    * Extract content starting from a word
    * @param $string - Content
    * @param $start - str
    * @param $end - str
    * @return string
    */
    public static function extractTextStartingFrom( $string, $start, $end ) {
        $pos = stripos( $string, $start );
        $str = substr( $string, $pos );
        $str2 = substr( $str, 0 );
        $secondPos = stripos( $str2, $end );
        $str3 = substr( $str2, 0, $secondPos );
        $unit = trim( $str3 );
        return $unit;
    }


    /**
    * Crop filename
    * @return string
    */
    public static function cropFilename( $text, $length, $strTrail='...' ) {
        if( strlen( $text ) > $length ) {
            $ext = pathinfo( $text, PATHINFO_EXTENSION );
            return substr( $text, 0, $length ) . $strTrail . $ext;
        }
        return $text;
    }


    /**
    * Crop a word
    * @return string
    */
    public function cropWord( $text, $length, $strTrail='...' ) {
        if( strlen( $text ) > $length ) {
            return substr( $text, 0, $length ) . $strTrail;
        }
        return $text;
    }


    /**
    * Crop text
    * return str
    
    public function cropText( $string, $chars=50, $terminator='...' ) {
        $cutPos = $chars - mb_strlen( $terminator );
        $boundaryPos = mb_strrpos( mb_substr($string, 0, mb_strpos($string, ' ', $cutPos)), ' ');
        return mb_substr($string, 0, $boundaryPos === false ? $cutPos : $boundaryPos) . $terminator;
    }*/

    public static function cropText($textToTruncate, $maxLength = 75, $trailingChars='...' ) {
        //subtract the length of the ellipses from the max length value
        $maxLength -= mb_strlen($trailingChars);

        //check to see if the text provided is longer than the maximum length
        if( mb_strlen($textToTruncate)> $maxLength ) {
           //Since we're here then the text is longer than
           //the maximum length we wish to allow so we need
           //to truncate the text and add the truncate characters
           return mb_substr($textToTruncate,0,$maxLength).$trailingChars;
        }
        else {
           // string was already short enough, return the string
           $truncatedText = $textToTruncate;
        }

        //return the truncated text
        return $truncatedText;
    }


    /**
    * Crop text
    * return str
    
    public function cropText( $text, $intLength, $strTrail='...' ) {
        $text = preg_replace( "#\r|\n#", ' ', $text );
        $strTemp = '';
        if( strlen( $text ) > $intLength ) {
            $arrTemp = explode( ' ', $text );
            foreach( $arrTemp as $x ) {
            	if( strlen( $strTemp ) <= $intLength ) {
                    $strTemp .= ' ' . $this->cropWord( $x, 40 );
                }
            }
            return $strTemp . $strTrail;
        }
        else {
            return $text;
        }
    }*/


    /**
    * Scan through the whole text and create links
    * return str
    */
    public function makeLink( $text, $length=60 ) {
        $this->maxLengthURL = (int)$length;
        $pattern = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
        return preg_replace_callback( $pattern, array( $this, 'makeLinkCallback' ), $text );
    }


    /**
    * makeLink callback
    * return str
    */
    public function makeLinkCallback( $matches ) {
        $maxDepthIfOverLength = 2;
        $ellipsis = '&hellip;';
        $urlFull  = $matches[0];
        $urlShort = '';

        if( strlen( $urlFull ) > $this->maxLengthURL ) {
            $parts = parse_url( $urlFull );

            if( isset( $parts['scheme'] ) && isset( $parts['host'] ) ) {
                $urlShort = $parts['scheme'] . '://' . preg_replace('/^www\./', '', $parts['host'] ) . '/';
            }

            $pathComponents = explode( '/', trim( $parts['path'], '/' ) );
            $urlString = array( );

            foreach( $pathComponents as $dir ) {
                $urlString[] = $dir . '/';
            }

            if( isset( $parts['query'] ) ) {
                $urlString[] = '?' . $parts['query'];
            }

            if( isset( $parts['fragment'] ) ) {
                $urlString[] = '#' . $parts['fragment'];
            }
            for( $i=0; $i<$urlString; $i++ ) {
                $curr = $urlString[$i];
                if( $i >= $maxDepthIfOverLength || strlen( $urlShort) + strlen( $curr ) > $this->maxLengthURL ) {
                    if( $i == 0 && strlen( $urlShort ) < $this->maxLengthURL ) {
                        // Always show a portion of first directory
                        $urlShort .= substr( $curr, 0, $this->maxLengthURL - strlen( $urlShort ) );
                    }
                    $urlShort .= $ellipsis;
                    break;
                }
                $urlShort .= $curr;
            }

        }
        else {
            $urlShort = $urlFull;
            $scheme = parse_url( $urlFull );
            $urlFull = isset( $scheme['scheme'] ) ? $urlFull : 'http://' . $urlFull;
        }
        return "<a href=\"$urlFull\" target=\"_blank\">$urlShort</a>";
    }


    /**
    * Scan through the whole text and highlight word(s)
    * return str
    */
    public static function highlight( $string, $words_to_highlight, $delimiter=' ', $case=0,
                                      $left_string='<strong>', $right_string='</strong>' ) {

        $list_of_words = preg_replace("[^-a-zA-Z0-9&']", ' ', $words_to_highlight );
        $list_array    = explode( ' ', $list_of_words );
        $sizeof = sizeof( $list_array );

        for( $i=0; $i<$sizeof; $i++ ) {
        	if( strlen( $list_array[$i] ) == 1 ) {
        		$list_array[$i] = '';
        	}
            $list_of_words    = implode( ' ', $list_array );
            $list_of_words_cp = $list_of_words;

            $final = array( );
            preg_match_all( '/<(.+?)>/is', $string, $list_of_words );

            foreach( array_unique( $list_of_words[0]) as $key => $value ) {
            	$final['<|'.$key.'|>'] = $value;
            }

            $string = str_replace( $final, array_keys( $final ),$string );
            $list_of_words_cp = preg_replace( ' +', '|', $list_of_words_cp );

            if( $list_of_words_cp{0} == '|' ) {
            	$list_of_words_cp{0} = '';
            }

            if( $list_of_words_cp{strlen( $list_of_words_cp )-1} == '|' ) {
              	$list_of_words_cp{strlen($list_of_words_cp)-1} = '';
            }

            $list_of_words_cp = '(' . trim( $list_of_words_cp ) . ')';

            if( $case == 0 ) {
            	$string = preg_replace( "$list_of_words_cp", "$left_string"."\\1"."$right_string", $string );
                $string = str_replace( array_keys( $final ), $final, $string );
                return stripslashes( $string );
            }
            else {
            	$string = preg_replace( "$list_of_words_cp", "$left_string"."\\1"."$right_string", $string );
                $string = str_replace( array_keys( $final ), $final,$string );
                return stripslashes( $string );
            }
        }
    }


    /**
    * Returns a string format in bytes
    * Refer: http://www.php.net/manual/en/faq.using.php#faq.using.shorthandbytes
    * return int
    */
    public static function strToBytes( $sizeStr ) {
        switch( substr( $sizeStr, -1 ) ) {
            case 'M': case 'm': return (int)$sizeStr * 1048576;
            case 'K': case 'k': return (int)$sizeStr * 1024;
            case 'G': case 'g': return (int)$sizeStr * 1073741824;
            default: return $sizeStr;
        }
    }


    /**
    * Returns a byte format in readable form
    * return int
    */
    public static function bytesToStr( $bytes ) {
        if( $bytes >= 1073741824 ) {
            $bytes = number_format( $bytes / 1073741824, 1, '.', '') . 'GB';
        }
        else if( $bytes >= 1048576 ) {
            $bytes = number_format( $bytes / 1048576, 1, '.', '') . 'MB';
        }
        else if( $bytes >= 1024 ) {
            $bytes = number_format( $bytes / 1024, 0) . 'KB';
        }
        else {
            $bytes = number_format( $bytes, 0) . 'B';
        }
        return $bytes;
    }
}
?>