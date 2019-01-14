<?php
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: Resource.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Resource extends ResBundle {


    // Properties


    /**
    * Resource Constructor
    * @return void
    */
    function __construct( ) {
        // Rules of choice depends on the text string. A text string may contain more than one choices.
        // For e.g: He|She has {n} account|accounts
        // Rules apply for the above e.g will have an of array( {n}=="he", {n}==1 )
        $this->rules['choice'] = array( '{n}==1' );
        $this->rules['currency'] = 'USD$';
        $this->rules['dateFormat'] = array( 'j/n/Y' => 'd/M/yyyy',
                                            'j/n/y' => 'd/M/yy',
                                            'd/m/Y' => 'dd/MM/yyyy',
                                            'd/m/y' => 'dd/MM/yy',
                                            'Y-m-d' => 'yyyy-MM-dd',
                                            'l, j F, Y' => 'dddd, d MMMM, yyyy',
                                            'j F, Y' => 'd MMMM, yyyy' );

        $this->rules['timeFormat'] = array( 'g:i A' => 'h:mm AM/PM',
                                            'h:i A' => 'hh:mm AM/PM',
                                            'G:i' => 'H:mm',
                                            'H:i' => 'HH:mm',
                                            'g:i:s A' => 'h:mm:ss AM/PM',
                                            'h:i:s A' => 'hh:mm:ss AM/PM',
                                            'G:i:s' => 'H:mm:ss',
                                            'H:i:s' => 'HH:mm:ss' );
	}
}
?>