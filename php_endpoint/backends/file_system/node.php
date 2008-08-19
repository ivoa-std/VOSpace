<?php

require_once(BACKEND.'config.backend.inc');

class Node {

  public $uri;
  public $file_path;
  public $properties;

  function __construct($uri) {

    $this->uri = $uri;
    $this->file_path = str_replace( VOSPACE_ROOT.'/', FILE_SYSTEM_ROOT, $uri );
  }

  function populateProperties($detail = "min"){
    // tells the node to fill in it's properties values
    // file or directory had better exist!
    global $provided_properties;
    $f_stats = stat($this->file_path);
    $this->properties = $provided_properties;
    $this->properties[0]["_"] = $f_stats["size"];
    $this->properties[1]["_"] = DATA_OWNER;
    $this->properties[2]["_"] = $f_stats["mtime"];
    $this->properties[3]["_"] = $f_stats["ctime"];
  }

  function exists(){
    if( file_exists( $this->file_path ) )
      return True;

    return False;
  }

}

?>
