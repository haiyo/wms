<?php
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Friday, July 27, 2012
 * @version $Id: HTML2Text.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HTML2Text {


    /**
     *  Contains the HTML content to convert.
     *
     *  @var string $html
     *  @access public
     */
    private $html;

    /**
     *  Contains the converted, formatted text.
     *
     *  @var string $text
     *  @access public
     */
    private $text;



    /**
     *  List of preg* regular expression patterns to search for,
     *  used in conjunction with $replace.
     *
     *  @var array $search
     *  @access public
     *  @see $replace
     */
    private $search = array(
        "/\r/",                                  // Non-legal carriage return
        "/[\n\t]+/",                             // Newlines and tabs
        '/[ ]{2,}/',                             // Runs of spaces, pre-handling
        '/<script[^>]*>.*?<\/script>/i',         // <script>s -- which strip_tags supposedly has problems with
        '/<style[^>]*>.*?<\/style>/i',           // <style>s -- which strip_tags supposedly has problems with
        //'/<!-- .* -->/',                         // Comments -- which strip_tags might have problem a with
        '/<h[123][^>]*>(.*?)<\/h[123]>/ie',      // H1 - H3
        '/<h[456][^>]*>(.*?)<\/h[456]>/ie',      // H4 - H6
        '/<p[^>]*>/i',                           // <P>
        '/<br[^>]*>/i',                          // <br>
        '/<b[^>]*>(.*?)<\/b>/ie',                // <b>
        '/<strong[^>]*>(.*?)<\/strong>/ie',      // <strong>
        '/<i[^>]*>(.*?)<\/i>/i',                 // <i>
        '/<em[^>]*>(.*?)<\/em>/i',               // <em>
        '/(<ul[^>]*>|<\/ul>)/i',                 // <ul> and </ul>
        '/(<ol[^>]*>|<\/ol>)/i',                 // <ol> and </ol>
        '/<li[^>]*>(.*?)<\/li>/i',               // <li> and </li>
        '/<li[^>]*>/i',                          // <li>
        '/<a [^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/ie',  // <a href="">
        '/<hr[^>]*>/i',                          // <hr>
        '/(<table[^>]*>|<\/table>)/i',           // <table> and </table>
        '/(<tr[^>]*>|<\/tr>)/i',                 // <tr> and </tr>
        '/<td[^>]*>(.*?)<\/td>/i',               // <td> and </td>
        '/<th[^>]*>(.*?)<\/th>/ie',              // <th> and </th>
        '/&(nbsp|#160);/i',                      // Non-breaking space
        '/&(quot|rdquo|ldquo|#8220|#8221|#147|#148);/i',
		                                         // Double quotes
        '/&(apos|rsquo|lsquo|#8216|#8217);/i',   // Single quotes
        '/&gt;/i',                               // Greater-than
        '/&lt;/i',                               // Less-than
        '/&(amp|#38);/i',                        // Ampersand
        '/&(copy|#169);/i',                      // Copyright
        '/&(trade|#8482|#153);/i',               // Trademark
        '/&(reg|#174);/i',                       // Registered
        '/&(mdash|#151|#8212);/i',               // mdash
        '/&(ndash|minus|#8211|#8722);/i',        // ndash
        '/&(bull|#149|#8226);/i',                // Bullet
        '/&(pound|#163);/i',                     // Pound sign
        '/&(euro|#8364);/i',                     // Euro sign
        '/&[^&;]+;/i',                           // Unknown/unhandled entities
        '/[ ]{2,}/'                              // Runs of spaces, post-handling
    );

    /**
     *  List of pattern replacements corresponding to patterns searched.
     *
     *  @var array $replace
     *  @access public
     *  @see $search
     */
    private $replace = array(
        '',                                     // Non-legal carriage return
        ' ',                                    // Newlines and tabs
        ' ',                                    // Runs of spaces, pre-handling
        '',                                     // <script>s -- which strip_tags supposedly has problems with
        '',                                     // <style>s -- which strip_tags supposedly has problems with
        //'',                                     // Comments -- which strip_tags might have problem a with
        "strtoupper(\"\n\n\\1\n\n\")",          // H1 - H3
        "ucwords(\"\n\n\\1\n\n\")",             // H4 - H6
        "\n\n\t",                               // <P>
        "\n",                                   // <br>
        'strtoupper("\\1")',                    // <b>
        'strtoupper("\\1")',                    // <strong>
        '_\\1_',                                // <i>
        '_\\1_',                                // <em>
        "\n\n",                                 // <ul> and </ul>
        "\n\n",                                 // <ol> and </ol>
        "\t* \\1\n",                            // <li> and </li>
        "\n\t* ",                               // <li>
        '$this->buildLinkList("\\1", "\\2")',   // <a href="">
        "\n-------------------------\n",        // <hr>
        "\n\n",                                 // <table> and </table>
        "\n",                                   // <tr> and </tr>
        "\t\t\\1\n",                            // <td> and </td>
        "strtoupper(\"\t\t\\1\n\")",            // <th> and </th>
        ' ',                                    // Non-breaking space
        '"',                                    // Double quotes
        "'",                                    // Single quotes
        '>',
        '<',
        '&',
        '(c)',
        '(tm)',
        '(R)',
        '--',
        '-',
        '*',
        '£',
        'EUR',                                  // Euro sign. € ?
        '',                                     // Unknown/unhandled entities
        ' '                                     // Runs of spaces, post-handling
    );

    /**
     *  Contains a list of HTML tags to allow in the resulting text.
     *
     *  @var string $allowed_tags
     *  @access public
     *  @see set_allowed_tags()
     */
    private $allowedTags = '';

    /**
     *  Contains the base URL that relative links should resolve to.
     *
     *  @var string $url
     *  @access public
     */
    private $url;

    /**
     *  Indicates whether content in the $html variable has been converted yet.
     *
     *  @var boolean $_converted
     *  @access private
     *  @see $html, $text
     */
    private $converted = false;

    /**
     *  Contains URL addresses from links to be rendered in plain text.
     *
     *  @var string $_link_list
     *  @access private
     *  @see _build_link_list()
     */
    private $linkList = '';
    private $buildLink = false;
    
    /**
     *  Number of valid links detected in the text, used for plain text
     *  display (rendered similar to footnotes).
     *
     *  @var integer $_link_count
     *  @access private
     *  @see _build_link_list()
     */
    private $linkCount = 0;
    
    
    /**
    * HTML2Text
    * @returns void
    */
    function __construct( $source='', $isFile=false ) {
        if( !empty( $source ) ) {
            $this->setHTML( $source, $isFile );
        }
    }


    /**
     *  Loads source HTML into memory, either from $source string or a file.
     *  @param string $source HTML content
     *  @param boolean $from_file Indicates $source is a file to pull content from
     *  @access public
     *  @return void
     */
    public function setHTML( $source, $isFile=false ) {
        $this->html = $source;

        if( $isFile && file_exists( $source ) ) {
            $fp = fopen( $source, 'r' );
            $this->html = fread( $fp, filesize($source) );
            fclose($fp);
        }
        $this->converted = false;
    }
    
    
    /**
     *  Returns the text, converted from HTML.
     *  @access public
     *  @return string
     */
    public function getText( ) {
        if( !$this->converted ) {
            $this->convert( );
        }
        return $this->text;
    }
    
    
    /**
     *  Sets the allowed HTML tags to pass through to the resulting text.
     *  Tags should be in the form "<p>", with no corresponding closing tag.
     *  @access public
     *  @return void
     */
    public function setAllowedTags( $allowedTags='' ) {
        if( !empty( $allowedTags ) ) {
            $this->allowedTags = $allowedTags;
        }
    }
    

    /**
     *  Workhorse function that does actual conversion.
     *  First performs custom tag replacement specified by $search and
     *  $replace arrays. Then strips any remaining HTML tags, reduces whitespace
     *  and newlines to a readable format, and word wraps the text to
     *  $width characters.
     *
     *  @access private
     *  @return void
     */
    private function convert( ) {
        // Variables used for building the link list
        $this->linkCount = 0;
        $this->linkList = '';

        $text = trim( stripslashes( $this->html ) );

        // Run our defined search-and-replace
        preg_match_all( '/(title|alt)="([^"]+)"/', $text, $words );
        
        if( !isset( $words[2] ) || sizeof( $words[2] ) == 0  ) {
            return false;
        }
        $text .= implode(' ', $words[2]) . ' ';
        
        $getTitle = stristr( $this->allowedTags, 'title' );
        $getMeta  = stristr( $this->allowedTags, 'meta' );
        
        if( $getTitle || $getMeta ) {
            $DOM = new DOMDocument( );
            @$DOM->loadHTML( $text );
            
            if( $getTitle ) {
                $nodes = $DOM->getElementsByTagName('title');
                $text .= $nodes->item(0)->nodeValue . ' ';
            }
            if( $getMeta ) {
                $metas = $DOM->getElementsByTagName('meta');

                for( $i = 0; $i<$metas->length; $i++ ) {
                    $meta = $metas->item($i);
                    if($meta->getAttribute('name') == 'description')
                        $text .= $meta->getAttribute('content') . ' ';
                    if($meta->getAttribute('name') == 'keywords')
                        $text .= $meta->getAttribute('content') . ' ';
                }
            }
        }
        
        $text = preg_replace($this->search, $this->replace, $text);
        $text = strip_tags( $text, $this->allowedTags);
        $text = str_replace(array("\r", "\r\n", "\n"), '', $text );
        
        // Add link list
        if ( !empty( $this->linkList ) && $this->buildLink ) {
            $text .= "\n\nLinks:\n------\n" . $this->linkList;
        }

        // Wrap the text to a readable format
        // for PHP versions >= 4.0.2. Default width is 75
        // If width is 0 or less, don't wrap the text.
        /*if ( $this->width > 0 ) {
        	$text = wordwrap($text, $this->width);
        }*/

        $this->text = $text;
        $this->converted = true;
    }

    /**
     *  Helper function called by preg_replace() on link replacement.
     *
     *  Maintains an internal list of links to be displayed at the end of the
     *  text, with numeric indices to the original point in the text they
     *  appeared. Also makes an effort at identifying and handling absolute
     *  and relative links.
     *
     *  @param string $link URL of the link
     *  @param string $display Part of the text to associate number with
     *  @access private
     *  @return string
     */
    private function buildLinkList( $link, $display ) {
		if ( substr($link, 0, 7) == 'http://' || substr($link, 0, 8) == 'https://' ||
             substr($link, 0, 7) == 'mailto:' ) {
            $this->linkCount++;
            $this->linkList .= "[" . $this->linkCount . "] $link\n";
            $additional = ' [' . $this->linkCount . ']';
		} elseif ( substr($link, 0, 11) == 'javascript:' ) {
			// Don't count the link; ignore it
			$additional = '';
		// what about href="#anchor" ?
        } else {
            $this->linkCount++;
            $this->linkList .= "[" . $this->linkCount . "] " . $this->url;
            if ( substr($link, 0, 1) != '/' ) {
                $this->linkList .= '/';
            }
            $this->linkList .= "$link\n";
            $additional = ' [' . $this->linkCount . ']';
        }

        return $display . $additional;
    }
}
?>