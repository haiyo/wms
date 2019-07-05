<?php
namespace Library\Helper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Templator.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HTMLHelper {


    /* Holds the array of filehandles
    FILELIST[HANDLE] == "fileName" */
    protected $fileList;


    /* Holds the array of dynamic
    blocks, and the fileHandles they
    live in. */
    protected $dynamic;


    /* Holds the array of Variable handles.
    PARSEVARS[HANDLE] == "value" */
    protected $parseVars;


    /* We only want to load a template
    once - when it's used.
    LOADED[FILEHANDLE] == 1 if loaded
    undefined if not loaded yet. */
    protected $loaded;


    /* Holds the handle names assigned
    by a call to parse( ) */
    protected $handle;


    /* Holds path-to-templates */
    protected $root;


    /* Holds the HANDLE to the last
    template parsed by parse( ) */
    protected $last;


    /* Strict template checking.
    Unresolved vars in templates will
    generate a warning when found. */
    protected $strict;


    /**
    * Constructor
    * @returns void
    */
    function __construct( $dir='' ) {
        $this->fileList	 = array( );
        $this->dynamic	 = array( );
        $this->parseVars = array( );
	    $this->loaded	 = array( );
	    $this->handle	 = array( );
	    $this->strict    = true;

    	if( is_dir( $dir ) ) {
    	    $this->root = $dir;
    	}
    }


    /**
    * A quick check of the template file before reading it.
    * This is -not- a reliable check, mostly due to inconsistencies in the way
    * PHP determines if a file is readable.
    * @returns bool
    */
    public function isSafe( $filename ) {
    	return file_exists( $filename );
    }


    /**
    * Grabs a template from the root dir and reads it into a big string
    * @returns str
    */
    public function getTemplate( $template ) {
        $fileName =	$this->root . $template;
	    $contents = @implode( '',( file( $fileName ) ) );
        return $contents;
    }


	/**
    * This routine get's called by parse() and does the actual <?VAR?> to VALUE
    * conversion within the template.
    * @returns str
    */
    public function parseTemplate( $template, $tplArray ) {
        foreach( $tplArray as $key => $val ) {
			if( !empty( $key ) ) {
				if( gettype($val) != 'string' ) {
				    if( is_array( $val ) ) {
				        var_dump($val);
                    }
					settype($val, 'string' );
				}
                $template = str_replace( '<?' . $key . '?>', "$val", "$template" );
			}
		}
		return $template;
	}


    /**
    * The meat of the whole class. The magic happens here.
    * @return void
    */
    public function parse( $returnVar, $fileTags ) {
        $append = false;
        $this->last = $returnVar;
        $this->handle[$returnVar] = 1;

        if( is_array( $fileTags ) ) {
            // Clear any previous data
            unset($this->$returnVar);
            foreach( $fileTags as $val ) {
                if( !isset( $this->$val ) || empty( $this->$val ) ) {
                    $this->loaded["$val"] = 1;

                    if( isset( $this->dynamic["$val"] ) ) {
                        $this->parseDynamic( $val, $returnVar );
                    }
                    else {
                       	$fileName   = $this->fileList["$val"];
                        $this->$val = $this->getTemplate( $fileName );
                    }
                }
                //Array context implies overwrite
                $this->$returnVar = $this->parseTemplate( $this->$val, $this->parseVars );

                //For recursive calls.
                $this->assign( array( $returnVar => $this->$returnVar ) );
            }
        }
        else {
			// fileTags is not an array
			$val = $fileTags;

			if( substr( $val, 0, 1 ) == '.' ) {
				// Append this template to a previous ReturnVar
				$append = true;
				$val = substr( $val, 1 );
			}
			if( !isset( $this->$val ) || empty( $this->$val ) ) {
                $this->loaded["$val"] = 1;
				if( isset( $this->dynamic["$val"] ) ) {
					$this->parseDynamic( $val, $returnVar );
				}
				else {
					$fileName   = $this->fileList["$val"];
					$this->$val = $this->getTemplate( $fileName );
				}
			}
			if( $append ) {
				if( !isset( $this->$returnVar ) ) $this->$returnVar = NULL;
                $this->$returnVar .= $this->parseTemplate( $this->$val, $this->parseVars );
			}
			else {
				$this->$returnVar = $this->parseTemplate( $this->$val, $this->parseVars );
			}
			//	For recursive calls.
			$this->assign( array( $returnVar => $this->$returnVar ) );
		}
		return;
	}


	/**
    * Returns the raw data from a parsed handle.
    * @returns str
    */
    public function fetch( $template='' ) {
		if( empty( $template ) ) {
			$template = $this->last;
		}
		if( isset( $this->$template ) || !empty( $this->$template ) ) {
			return $this->$template;
		}
	}


	/**
    * A dynamic block lives inside another template file. It will be stripped
    * from the template when parsed and replaced with the {$Tag}.
    * @returns bool
    */
    public function defineDynamic( $macro, $parentName ) {
		//	A dynamic block lives inside another template file.
		//	It will be stripped from the template when parsed
		//	and replaced with the {$Tag}.
		$this->dynamic["$macro"] = $parentName;
		return true;
	}


	/**
    * Parse a dynamic block lives inside another template file. It will be stripped
    * from the template when parsed and replaced with the {$Tag}.
    * @returns bool
    */
    public function parseDynamic( $macro, $macroName ) {
		// The file must already be in memory.
		$parentTag = $this->dynamic["$macro"];

		if( !isset( $this->$parentTag ) || empty( $this->$parentTag ) ) {
			$filename = $this->fileList[$parentTag];
			$this->$parentTag = $this->getTemplate($filename);
			$this->loaded[$parentTag] = 1;
		}
		if( $this->$parentTag ) {
			$template  = $this->$parentTag;
			$dataArray = explode( "\n", $template );
			$newMacro  = '';
			$newParent = '';
			$outside   = true;
			$start     = false;
			$end       = false;

            foreach( $dataArray as $lineNum => $lineData ) {
				$lineTest = trim($lineData);
				if("<!-- BEGIN DYNAMIC BLOCK: $macro -->" == "$lineTest" ) {
					$start   = true;
					$end     = false;
					$outside = false;
				}
				if("<!-- END DYNAMIC BLOCK: $macro -->" == "$lineTest" ) {
					$start   = false;
					$end     = true;
					$outside = true;
				}
				if( (!$outside) && (!$start) && (!$end) ) {
					$newMacro .= "$lineData\n"; // Restore linebreaks
				}
				if( ($outside) && (!$start) && (!$end) ) {
					$newParent .= "$lineData\n"; // Restore linebreaks
				}
				if( $end ) {
					$newParent .= '<?' . $macroName."?>\n";
				}
                // Next line please
				if( $end   ) { $end   = false; }
				if( $start ) { $start = false; }
			}
			$this->$macro = $newMacro;
			$this->$parentTag = $newParent;
			return true;
		}
		return false;
	}


	/**
    * Strips a DYNAMIC BLOCK from a template.
    * @returns bool
    */
    public function clearDynamic( $macro='' ) {
		if( empty( $macro ) ) { return false; }
		// The file must already be in memory.
		$parentTag = $this->dynamic["$macro"];

		if( !isset( $this->$parentTag ) || empty( $this->$parentTag ) ) {
			$filename = $this->fileList[$parentTag];
			$this->$parentTag = $this->getTemplate($filename);
			$this->loaded[$parentTag] = 1;
		}
		if( $this->$parentTag ) {
			$template  = $this->$parentTag;
			$dataArray = explode( "\n", $template );
			$newParent = '';
			$outside   = true;
			$start     = false;
			$end       = false;

            foreach( $dataArray as $lineNum => $lineData ) {
				$lineTest = trim($lineData);
				if( "<!-- BEGIN DYNAMIC BLOCK: $macro -->" == "$lineTest" ) {
					$start   = true;
					$end     = false;
					$outside = false;
				}
				if( "<!-- END DYNAMIC BLOCK: $macro -->" == "$lineTest" ) {
					$start   = false;
					$end     = true;
					$outside = true;
				}
				if( ($outside) && (!$start) && (!$end) ) {
					$newParent .= "$lineData\n"; // Restore linebreaks
				}
				// Next line please
				if( $end   ) { $end   = false; }
				if( $start ) { $start = false; }
			}
			$this->$parentTag = $newParent;
			return true;
		}
		return false;
	}


    /**
    * Define file list
    * @returns bool
    */
	public function define( $fileList ) {
        foreach( $fileList as $fileTag => $fileName ) {
			$this->fileList["$fileTag"] = $fileName;
		}
		return true;
	}


    /**
    * Clear variable
    * @returns void
    */
	public function clear( $returnVar='' ) {
		// Clears out hash created by call to parse()
		if( !empty( $returnVar ) ) {
			if( !is_array( $returnVar ) ) {
				unset($this->$returnVar);
				return;
			}
			else {
                foreach( $returnVar as $val ) {
					unset($this->$val);
				}
				return;
			}
		}
		// Empty - clear all of them
        foreach( $this->handle as $key => $val ) {
			$KEY = $key;
			unset($this->$KEY);
		}
		return;
	}


    /**
    * Clear all
    * @returns void
    */
	public function clearAll( ) {
		$this->clear( );
		$this->clearAssign( );
		$this->clearDefine( );
		$this->clearTPL( );
		return;
	}


    /**
    * Clear template
    * @returns bool
    */
	public function clearTPL( $fileHandle='' ) {
		if( empty( $this->loaded ) ) {
			// Nothing loaded, nothing to clear
			return true;
		}
		if( empty( $fileHandle ) ) {
			// Clear ALL fileHandles
            foreach( $this->loaded as $key => $val ) {
				unset($this->$key);
			}
			unset($this->loaded);
			return true;
		}
		else {
			if( is_array( $fileHandle ) ) {
				if( isset( $this->$fileHandle ) || !empty( $this->$fileHandle ) ) {
					unset($this->loaded[$fileHandle]);
					unset($this->$fileHandle);
					return true;
				}
			}
			else {
                foreach( $fileHandle as $key => $val ) {
					unset($this->loaded[$key]);
					unset($this->$key);
				}
				return true;
			}
		}

		return false;
	}


	/**
    * Clear Defined Template
    * @returns void
    */
    public function clearDefine( $fileTag='' ) {
		if( empty( $fileTag ) ) {
			unset($this->fileList);
			return;
		}
		if( is_array( $fileTag ) ) {
			unset($this->fileList[$fileTag]);
			return;
		}
		else {
            foreach( $fileTag as $tag => $val ) {
				unset($this->fileList[$tag]);
			}
			return;
		}
	}
	

    /**
    * Clears all variables set by assign()
    * @returns void
    */
	public function clearAssign( ) {
		if( !empty( $this->parseVars ) ) {
            foreach( $this->parseVars as $ref => $val ) {
				unset($this->parseVars["$ref"]);
			}
		}
	}


    /**
    * Clears links
    * @returns void
    */
	public function clearHref( $href ) {
		if( !empty( $href ) ) {
			if( is_array( $href ) ) {
				unset($this->parseVars[$href]);
				return;
			}
			else {
                foreach( $href as $ref => $val ) {
					unset($this->parseVars[$ref]);
				}
				return;
			}
		}
		else {
			// Empty - clear them all
			$this->clearAssign( );
		}
		return;
	}


    /**
    * Assign Templates
    * @returns void
    */
	public function assign( $tplArray, $trailer='' ) {
		if( is_array( $tplArray ) ) {
            foreach( $tplArray as $key => $val ) {
				if( !empty( $key ) ) {
					//	Empty values are allowed
					//	Empty Keys are NOT
					$this->parseVars["$key"] = $val;
				}
			}
		}
		else {
			// Empty values are allowed in non-array context now.
			if( !empty( $tplArray ) ) {
				$this->parseVars["$tplArray"] = $trailer;
			}
		}
	}


    /**
    * Return the value of an assigned variable.
    * @returns str || false
    */
	public function getAssigned( $tplName='' ) {
		if( empty( $tplName ) ) { return false; }
		if( isset( $this->parseVars["$tplName"] ) ) {
			return $this->parseVars["$tplName"];
		}
		else {
			return false;
        }
	}
}
?>