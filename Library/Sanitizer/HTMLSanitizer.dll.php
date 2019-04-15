<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: HTMLSanitizer.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HTMLSanitizer {


    // Properties
    /**
     * Determinates all entities.
     * ( 9 cols of 10 chars + 1 cols of 9 chars )
     */
    static $entities/*Array*/ = array
    (
        "&euro;"   , "&quot;"   , "&apos;"   , "&amp;"    , "&lt;"     , "&gt;"     , "&iexcl;"  , "&cent;"   , "&pound;"  , "&curren;" ,
        "&yen;"    , "&brvbar;" , "&sect;"   , "&uml;"    , "&copy;"   , "&ordf;"   , "&not;"    , "&shy;"    , "&reg;"    , "&macr;"   ,
        "&deg;"    , "&plusmn;" , "&sup2;"   , "&sup3;"   , "&acute;"  , "&micro;"  , "&para;"   , "&middot;" , "&cedil;"  , "&sup1;"   ,
        "&ordm;"   , "&raquo;"  , "&frac14;" , "&frac12;" , "&frac34;" , "&iquest;" , "&Agrave;" , "&Aacute;" , "&Atilde;" , "&Auml;"   ,
        "&Aring;"  , "&AElig;"  , "&Ccedil;" , "&Egrave;" , "&Eacute;" , "&Ecirc;"  , "&Euml;"   , "&Igrave;" , "&Iacute;" , "&Icirc;"  ,
        "&Iuml;"   , "&ETH;"    , "&Ntilde;" , "&Ograve;" , "&Oacute;" , "&Ocirc;"  , "&Otilde;" , "&Ouml;"   , "&times;"  , "&Oslash;" ,
        "&Ugrave;" , "&Uacute;" , "&Ucirc;"  , "&Uuml;"   , "&Yacute;" , "&THORN;"  , "&szlig;"  , "&agrave;" , "&aacute;" , "&acirc;"  ,
        "&atilde;" , "&auml;"   , "&aring;"  , "&aelig;"  , "&ccedil;" , "&egrave;" , "&eacute;" , "&ecirc;"  , "&euml;"   , "&igrave;" ,
        "&iacute;" , "&icirc;"  , "&iuml;"   , "&eth;"    , "&ntilde;" , "&ograve;" , "&oacute;" , "&ocirc;"  , "&otilde;" , "&ouml;"   ,
        "&divide;" , "&oslash;" , "&ugrave;" , "&uacute;" , "&ucirc;"  , "&uuml;"   , "&yacute;" , "&thorn;"  , "&nbsp;"
    ) ;

    /**
     * Determinates all special chars.
     * ( 4 cols of 20 chars + 1 cols of 19 chars )
     */
    static $specialchars/*Array*/ = array
    (
        "€" , "\"", "'" , "&" , "<" , ">" , "¡" , "¢" , "£" , "¤" , "¥" , "¦" , "§" , "¨" , "©" , "ª" , "¬" , " " , "®" , "¯" ,
        "°" , "±" , "²" , "³" , "´" , "µ" , "¶" , "·" , "¸" , "¹" , "º" , "»" , "¼" , "½" , "¾" , "¿" , "À" , "Á" , "Ã" , "Ä" ,
        "Å" , "Æ" , "Ç" , "È" , "É" , "Ê" , "Ë" , "Ì" , "Í" , "Î" , "Ï" , "Ð" , "Ñ" , "Ò" , "Ó" , "Ô" , "Õ" , "Ö" , "×" , "Ø" ,
        "Ù" , "Ú" , "Û" , "Ü" , "Ý" , "Þ" , "ß" , "à" , "á" , "â" , "ã" , "ä" , "å" , "æ" , "ç" , "è" , "é" , "ê" , "ë" , "ì" ,
        "í" , "î" , "ï" , "ð" , "ñ" , "ò" , "ó" , "ô" , "õ" , "ö" , "÷" , "ø" , "ù" , "ú" , "û" , "ü" , "ý" , "þ" , "\u00A0"
    ) ;


    /**
    * HTMLSanitizer Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Return sanitize string
    * Remove HTML tags, including invisible text such as style
    * script code, and embedded objects. Add line breaks around
    * block-level tags to prevent word joining after tag removal.
    * @return string
    */
    public static function sanitize( $text ) {
        $text = preg_replace(
            array(
              // Remove invisible content
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',
              // Add line breaks before and after blocks
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ),
            $text );
        return $text;
    }


    /**
     * Decodes the specified string.
     * Example :
     * <?php
     * require_once( './library/asgard/net/HTMLEntities.php' )  ; // proposition de package.
     * ?>
     * <script language="javascript">
     *      alert( '<?php echo HTMLEntities::decode( "&lt;b&gt;hello world&lt;/b&gt;" ) ; ?>' ) ; // <b>hello world</b>
     * </script>
     *
     * @param String $text
     * @param Boolean $removeCRLF
     * @return the decode string.
     */
    public static function decode( $text/*String*/ , $removeCRLF/*Boolean*/ = false )
    {
        $i /*int*/         = 0 ;
        $ch /*String*/     = null ;
        $entity /*String*/ = null ;
        $len /*int*/       = count( self::$entities ) ;

        for( $i ; $i < $len ; $i++ )
        {
            $ch     = self::$specialchars[$i] ;
            $entity = self::$entities[$i] ;

            if( strpos( $text , $entity ) !== false )
            {
                $text   = str_replace( $entity , $ch , $text ) ;
            }
        }

        if( $removeCRLF )
        {
            $text = str_replace( "\r\n" , "" , $text ) ;
        }

        return $text;
    }

    /**
     * Decodes the specified string.
     * Example :
     * <?php
     * require_once( './library/asgard/net/HTMLEntities.php' )  ; // proposition de package.
     * ?>
     * <script language="javascript">
     *      alert( '<?php echo HTMLEntities::decodeEntityNumberToChar( "&#60;b&#62;hello world&#60;/b&#62;" ) ; ?>' ) ; // <b>hello world</b>
     * </script>
     *
     * @param String $text
     * @param Boolean $removeCRLF
     * @return the decode string.
     */
    public static function decodeEntityNumberToChar( $text/*String*/ , $removeCRLF/*Boolean*/ = false ) {
        $i /*uint*/        = 0 ;
        $ch /*String*/     = null ;
        $entity /*String*/ = null ;
        $len /*uint*/      = count( self::$entities ) ;

        for( $i ; $i < $len ; $i++ ) {
            $ch     = self::$specialchars[$i] ;
            $entity = self::getCharToEntityNumber( $ch ) ;
            if( strpos( $text , $entity ) !== false ) {
                $text = str_replace( $entity , $ch , $text ) ;
            }
        }
        if( $removeCRLF ) {
            $text = str_replace( "\r\n" , "" , $text ) ;
        }
        return $text;
    }

    /**
     * Encodes the specified text passed in argument.
     * Example :
     * <?php
     * require_once( './library/asgard/net/HTMLEntities.php' )  ; // proposition de package.
     * ?>
     * <script language="javascript">
     *      alert( '<?php echo HTMLEntities::encode( "<b>hello world</b>" ) ; ?>' ) ; // &lt;b&gt;hello world&lt;/b&gt;
     * </script>
     *
     *
     * @param String $text
     * @return a string encode text.
     */
    public static function encode( $text ) {
        $i /*int*/          = 0 ;
        $j /*int*/          = 0 ;
        $ch /*String*/       = '';
        $chToTest /*String*/ = '';
        $entity /*String*/   = '';
        $lenText /*int*/    = strlen( $text ) ;
        $lenEnt /*int*/     = count( self::$entities ) ;
        $tempText /*String*/ = $text ;

        for( $i=0 ; $i < $lenText ; $i++ ) {
            for( $j=0 ; $j < $lenEnt ; $j++ ) {
                $ch       = self::$specialchars[$j] ;
                $chToTest = substr( $text , $i , 1 ) ;
                $entity   = self::$entities[$j] ;

                if( $chToTest === $ch ) {
                    $tempText = str_replace( $ch , $entity , $tempText ) ;
                    break ;
                }
            }
        }
        return $tempText ;
    }

    /**
     * Encodes the specified text passed in argument.
     * Example :
     * <?php
     * require_once( './library/asgard/net/HTMLEntities.php' )  ; // proposition de package.
     * ?>
     * <script language="javascript">
     *      alert( '<?php echo HTMLEntities::encodeCharToEntityNumber( "<b>hello world</b>" ) ; ?>' ) ; // &#60;b&#62;hello world&#60;/b&#62;
     * </script>
     *
     *
     * @param String $text
     * @return a string encode text.
     */
    public static function encodeCharToEntityNumber( $text )/*String*/
    {
        $i /*uint*/        = 0 ;
        $ch /*String*/     = "" ;
        $entity /*String*/ = "" ;
        $len /*uint*/      = count( self::$entities ) ;

        for( $i=0 ; $i < $len ; $i++ )
        {
            $ch     = self::$specialchars[$i] ;
            $entity = self::getCharToEntityNumber( $ch ) ;

            if( strpos( $text , $ch ) !== false )
            {
                $text = str_replace( $ch , $entity , $text ) ;
            }

        }

        return $text ;
    }

    /**
     * Returns the entity name of the specified character in argument.
     * Returns an empty string value if the char passed-in argument isn't a special char to transform in entity string representation.
     * Example :
     * <?php
     * require_once( './library/asgard/net/HTMLEntities.php' )  ; // proposition de package.
     * ?>
     * <script language="javascript">
     *      alert( '<?php echo HTMLEntities::getCharToEntity( "<" ) ; ?>' ) ; // &lt;
     * </script>
     *
     * @param String $char
     * @return the entity name of the specified character in argument.
     */
    public static function getCharToEntity( $char/*String*/ )/*String*/
    {
        $index = array_search( $char , self::$specialchars , true ) ;
        return $index !== false ? self::$entities[$index] : null ;
    }

    /**
     * Returns the entity number string representation of the specified character in argument.
     * Example :
     * <?php
     * require_once( './library/asgard/net/HTMLEntities.php' )  ; // proposition de package.
     * ?>
     * <script language="javascript">
     *      alert( '<?php echo HTMLEntities::getCharToEntityNumber( "<" ) ; ?>' ) ; // &#60;
     * </script>
     *
     * @param String $char
     * @return the entity number string representation of the specified character in argument.
     */
    public static function getCharToEntityNumber( $char/*String*/ )/*String*/
    {
        return "&#" . ord( $char ) . ";" ;
    }

    /**
     * Returns the char representation of the specified entity number string value in argument or an empty string value.
     * Example :
     * <?php
     * require_once( './library/asgard/net/HTMLEntities.php' )  ; // proposition de package.
     * ?>
     * <script language="javascript">
     *      alert( '<?php echo HTMLEntities::getEntityNumberToChar( "&#60;" ) ; ?>' ) ; // <
     * </script>
     *
     * @param String $entityNumber
      * @return the char representation of the specified entity number string value in argument or an empty string value.
     */
    public static function getEntityNumberToChar( $entityNumber/*String*/ )/*String*/
    {
        if ( substr( $entityNumber , 0 , 1 ) == "&" && substr( $entityNumber , 1 , 1 ) == "#" && substr( $entityNumber , strlen( $entityNumber )-1 , 1 ) == ";" )
        {
            $r = split( "&#" , $entityNumber ) ;

            return chr( intval( $r[1] ) ) ;
        }
        else
        {
            return "" ;
        }
    }

    /**
     * Returns the hex code of the euro char because the Unicode number is different.
     * @example In PHP   => ord(€), returns 128
     * @example In flash => str.charCodeAt(0), returns 8364.
     * @param String
     * @return String with the hexa code of the euro char.
     */
    public static function convertEuroCharForFlash( $str /*String*/ ) /*String*/
    {
        return preg_replace( "/\x80/" , "&#x20AC;" , $str ) ;
    }
}
?>