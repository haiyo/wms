<?php
namespace Aurora\Admin;
use \Library\Util\Scheduler\Scheduler;
use \Library\Exception\Exceptions;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CronModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CronModel extends \Model {


    // Properties
    protected $Cron;


    /**
     * CountryModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Cron = new Cron( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function run( ) {
        $taskList = $this->Cron->getAll( );

        if( sizeof( $taskList ) > 0 ) {
            try {
                foreach( $taskList as $row ) {
                    $expression = $row['minute'] . ' ' . $row['hour'] . ' ' . $row['day'] . ' ' . $row['month'] . ' ' . $row['dayOfWeek'];

                    $Scheduler = new Scheduler( );
                    $Scheduler->php( ROOT . 'cron/' . $row['task'] )->at( $expression )->output(ROOT . 'log/cron.log',true );
                    $Scheduler->run( );
                }
            }
            catch( Exceptions $e ) {
                $e->record( );
            }
        }
    }
}
?>