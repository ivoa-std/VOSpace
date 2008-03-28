<?php 

include('config.inc');

class Property { 

  public $uri;
  public $value;
  public $readonly;

  function __construct($u, $v=null, $r=TRUE) {

    $this->uri = $u;
    $this->readonly = $r;
    if( $v )
      $this->value = $v;
  }

}

?>
