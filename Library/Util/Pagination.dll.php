<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <andylam@hwzcorp.com>
 * @since Saturday, February 19, 2005
 * @version $Id: Main.class.php, v 1.0 Exp $
 */
class Pagination {


    var $total;

    var $page;

    var $perPage;

    var $navLinks;

    var $sqlStart;

    var $nextPageInfo;


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function __construct( $total, $page, $perPage, $nextPageInfo='' ) {
        $this->total        = (int)$total;
        $this->page         = $page;
        $this->perPage      = (int)$perPage;
        $this->nextPageInfo = $nextPageInfo;
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    public function getNavLinks() {
        return $this->navLinks;
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     *
     * function SetperPage( $column, $value )
     * {
     * $sql = $GLOBALS['db']->update( 'UPDATE preferences SET
     * ' . addslashes( $column ) . ' = "' . (int)$value . '"' );
     *
     * return;
     * }*/

    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     *
     * function perPage( $staffID, $column )
     * {
     * $sql = $GLOBALS['db']->select( 'SELECT ' . addslashes( $column ) . ' FROM ' . $vezine['db_prefix'] . 'preferences
     * WHERE ref_id = "' . (int)$staffID . '"' );
     *
     * $row = $GLOBALS['db']->fetch( $sql );
     *
     * return $row[$column];
     * }*/

    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    public function getStartPoint( ) {
        if( $this->total == 0 ) {
            // No Limit
            $startPoint = '';
        }
        else {
            $startPoint = ' LIMIT ' . $this->sqlStart . ', ' . $this->perPage;
        }
        return $startPoint;
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    public function generate( ) {
        if( is_numeric( $this->total ) && $this->total > 0 ) {
            $pages = $this->total / $this->perPage;
            $pages = ceil( $pages );

            $HttpRequest = new HttpRequest();
            $page        = (string)$HttpRequest->request( GET, 'page' );
            $page        = is_numeric( $page ) ? $page : 1;

            // Make sure no results more than owns records
            if( $page > $pages ) {
                $page = $pages;
            }
            // No Negative
            else if( $page < 1 ) {
                $page = 1;
            }

            $this->sqlStart = ( $page - 1 ) * $this->perPage;

            if( ( $this->total < $this->perPage ) ) {
                $this->navLinks = '<strong>Page 1</strong> of 1';
            }
            else {
                $this->navLinks = '<strong>Result Page:</strong>&nbsp;&nbsp;&nbsp;&nbsp;';
            }

            if( $this->total >= $this->perPage && $this->total > 0 ) {
                if( $page == $pages ) {
                    $to = $page;
                }
                elseif( $page == $pages - 1 ) {
                    $to = $page + 1;
                }
                elseif( $page == $pages - 2 ) {
                    $to = $page + 2;
                }
                elseif( $page == $pages - 3 ) {
                    $to = $page + 3;
                }
                elseif( $page == $pages - 4 ) {
                    $to = $page + 4;
                }
                else {
                    $to = $page + 5;
                }

                if( $page == 1 || $page == 2 || $page == 3 || $page == 4 || $page == 5 ) {
                    $from = 1;
                }
                else {
                    $from = $page - 5;
                }

                if( $page == 1 ) {
                    $this->navLinks .= '';
                }
                else {
                    $previous       = $page - 1;
                    $this->navLinks .= '<a href="' . $this->page . $previous . '"><span class="prev">Previous</a></span>';
                }

                for( $i = $from; $i <= $to; $i++ ) {
                    if( $i != $page ) {
                        $this->navLinks .= '&nbsp;<a href="' . $this->page . $i . '">' . $i . '</a>&nbsp;';
                    }
                    else {
                        $ending  = '';
                        $ofTotal = '';

                        if( $i == $pages ) {
                            if( $this->nextPageInfo != ' Page' ) {
                                $ending = $this->nextPageInfo;
                            }

                            $ofTotal = ' of ' . $i . ' ' . $ending;
                        }

                        $this->navLinks .= '&nbsp;<font color="#990000"><strong>' . $i . '</strong></font>&nbsp;' . $ofTotal;
                    }
                }

                if( $page != $pages ) {
                    $next           = $page + 1;
                    $this->navLinks .= 'of ' . $pages . '&nbsp;
                                        <a href="' . $this->page . $next . '"><span class="next">Next</span> ' . $this->nextPageInfo . '</a>&nbsp;';
                }
            }
        }
        else {
            /* No Result */
            $this->navLinks = '<font color="#990000"><strong>No Records Found</strong></font>';
        }
    }
}

?>
