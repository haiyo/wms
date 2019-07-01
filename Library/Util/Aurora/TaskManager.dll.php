<?php
namespace Library\Util\Aurora;
use \Library\Util\TaskManager as DefTaskManager;
use \Library\Http\HttpResponse;
use \Library\Exception\InstantiationException;
use \Library\Exception\Aurora\TaskNotFoundException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaskManager.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaskManager extends DefTaskManager {


    // Properties
    protected $args;


    /**
    * Perform Task Escalation
    * @return void
    */
    public function escalate( $args ) {
        $this->args = $args;

        if( $this->tasks ) {
            // Need to do recursive, manually pass in the task;
            $this->importClass( $this->tasks );
            $this->invokeClass( $this->tasks );
        }
        else {
            throw new TaskNotFoundException( HttpResponse::HTTP_BAD_REQUEST );
        }
	}


    /**
    * Import Extension Controllers
    * @return void
    */
    private function importClass( $tasks ) {
        foreach( $tasks as $classPath => $childPath ) {
            if( sizeof( $childPath ) > 0 ) {
                $this->importClass( $childPath );
            }
        }
    }


    /**
    * Instantiate Extension Controllers
    * @throws InstantiationException
    * @return void
    */
    private function invokeClass( $tasks ) {
        foreach( $tasks as $classPath => $childPath ) {
            if( sizeof( $childPath ) > 0 ) {
                $this->invokeClass( $childPath );
            }
            else {
                $namespace = str_replace( '/', '\\', $classPath );
                $namespace = str_replace( basename( $classPath ), '', $namespace );
                //$classPath = $namespace[0] . '\\' . $namespace[1] . '\\' . basename( $classPath );
                $classPath = $namespace . basename( $classPath );
                $class = new $classPath;

                if( isset( $this->args[0] ) && method_exists( $class, $this->args[0] ) ) {
                    $action = $this->args[0];
                    $class->$action( $this->args );
                }
                else if( method_exists( $class, $this->task ) ) {
                    $action = $this->task;
                    $class->$action( $this->args );
                }
            }
        }
    }
}
?>