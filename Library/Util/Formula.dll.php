<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: Formula.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Formula {


    // Properties
    const PATTERN = '/(?:\-?\d+(?:\.?\d+)?[\+\-\*\/])+\-?\d+(?:\.?\d+)?/';
    const PARENTHESIS_DEPTH = 10;


    /**
    * Return the task list
    * @return mixed
    */
    public function calculate( $input ) {
        if( strpos($input, '+') != null || strpos($input, '-') != null ||
            strpos($input, '/') != null || strpos($input, '*') != null ) {

            //  Remove white spaces and invalid math chars
            $input = str_replace(',', '.', $input);
            $input = preg_replace('[^0-9\.\+\-\*\/\(\)]', '', $input);

            //  Calculate each of the parenthesis from the top
            $i = 0;
            while( strpos($input, '(') || strpos($input, ')' ) ) {
                $input = preg_replace_callback('/\(([^\(\)]+)\)/', 'self::callback', $input );
                $i++;

                if( $i > self::PARENTHESIS_DEPTH ) {
                    break;
                }
            }

            //  Calculate the result
            if( preg_match(self::PATTERN, $input, $match ) ) {
                return $this->compute( $match[0] );
            }
            // To handle the special case of expressions surrounded by global parenthesis like "(1+1)"
            if( is_numeric( $input ) ) {
                return $input;
            }
            return 0;
        }
        return $input;
    }


    /**
     * Return the task list
     * @return mixed
     */
    private function compute( $input ) {
        $compute = function( ) use ( $input ) {
            return eval('return '.$input.';');
        };
        return 0 + $compute( );
    }


    /**
     * Return the task list
     * @return mixed
     */
    private function callback( $input ) {
        if( is_numeric( $input[1] ) ) {
            return $input[1];
        }
        elseif( preg_match(self::PATTERN, $input[1], $match ) ) {
            return $this->compute( $match[0] );
        }
        return 0;
    }
}
?>