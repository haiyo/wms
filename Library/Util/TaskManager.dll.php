<?php
namespace Library\Util;

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
    * Add task to list
    * @return bool
    */
    public function foundTask( $xmlFile, $task ) {
        $XML = new XML( );
        $XMLElement = $XML->load( $xmlFile );
        $sizeof = sizeof( $XMLElement->task );
        $found = false;

        for( $i=0; $i<$sizeof; $i++ ) {
            $type = array_map('trim', explode(',', $XMLElement->task[$i]['type'] ) );

            if( in_array( $task, $type ) ) {
                $this->tasks = $this->recursive( $XMLElement->task[$i]->observer );

                // Assign explode first because array_pop expects by non-reference;
                $explode = explode('/', $task );
                $this->task = array_pop($explode );
                $found = true;
                break;
            }
        }
        return $found;
	}


    /**
    * Recusively add task to list
    * @return mixed
    */
    private function recursive( $XMLElement, $taskList=NULL ) {
        $sizeof = sizeof( $XMLElement );

        for( $i=0; $i<$sizeof; $i++ ) {
            $controller = (string)$XMLElement[$i]->attributes( );

            if( !isset( $taskList[$controller] ) ) {
                $taskList[$controller] = array( );
            }
            if( sizeof( $XMLElement[$i]->observer ) > 0 ) {
                $taskList[$controller] = $this->recursive( $XMLElement[$i]->observer, $taskList[$controller] );
            }
        }
        return $taskList;
    }
}
?>