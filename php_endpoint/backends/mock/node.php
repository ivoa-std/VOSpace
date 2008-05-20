<?php 

include('../config.inc');

require_once("properties.php");

class Node { 

  public $uri;
  public $ipath;
  public $properties;

  function __construct($uri) {

    global $provided_properties;

    $this->uri = $uri;
    $this->ipath = str_replace( VOSPACE_ROOT, '/vospace', $uri );
    $this->properties = $provided_properties;
    $this->properties[0]["_"] = "1";

  }

  function getProperties($detail = "min"){


  }

  function exists(){
    if( $this->uri == 'vos://exmple.org!vospace/foo.txt')
      return True;

    return False;
  }

}

?>
