<?php
namespace Markaxis\Calendar;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Label.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Label extends \DAO {


    // Properties
    

    /**
    * Label Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct();
	}


    /**
    * Retrieve Labels
    * @return mixed
    */
    public function getLabels( ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM markaxis_event_label
                                   ORDER BY sorting ASC',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['labelID']] = $row;
            }
        }
        return $list;
    }
}
?>