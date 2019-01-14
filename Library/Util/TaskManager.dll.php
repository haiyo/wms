<?php
namespace Library\Util;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: TaskManager.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaskManager {


    // Properties
    protected $task;
    protected $tasks;


    /**
    * TaskManager Constructor
    * @return void
    */
    function __construct( ) {
        $this->task  = NULL;
        $this->tasks = array( );
	}


    /**
    * Return the task list
    * @return mixed
    */
    public function getTasks( ) {
        return $this->tasks;
    }


    /**
    * Return the total number of task
    * @return mixed
    */
    public function countTasks( ) {
        return count( $this->tasks, COUNT_RECURSIVE );
    }


    /**
    * Add Task To List
    * @return void
    */
    public function addTask( $xmlFile, $task ) {
        File::import( LIB . 'Util/XML.dll.php' );
        $XML = new XML( );
        $XMLElement = $XML->load( $xmlFile );
        $sizeof = sizeof( $XMLElement->task );

        for( $i=0; $i<$sizeof; $i++ ) {
            if( $XMLElement->task[$i]['type'] == $task ) {
                $this->tasks = $this->recursive( $XMLElement->task[$i]->observer );
                break;
            }
        }
        $this->task = $task;
	}


    /**
    * Recusively Add Task To List
    * @return mixed
    */
    private function recursive( $XMLElement, $taskList=NULL ) {
        $sizeof = sizeof( $XMLElement );

        for( $i=0; $i<$sizeof; $i++ ) {
            $task = (string)$XMLElement[$i]->attributes( );
            if( !isset( $taskList[$task] ) ) {
                $taskList[$task] = array( );
            }
            if( sizeof( $XMLElement[$i]->observer ) > 0 ) {
                $taskList[$task] = $this->recursive( $XMLElement[$i]->observer,
                                                     $taskList[$task] );
            }
        }
        return $taskList;
    }
}
?>