<?php

require_once(BACKEND.'config.backend.inc');
require_once(BACKEND.'properties.php');
require_once(BACKEND.'views.php');
require_once(BACKEND.'protocols.php');
require_once(BACKEND.'node.php');

class VOSpace {

  function getViews(){ 
    global $provided_views;
    global $accepted_views;
    return array('accepts' => $accepted_views,
		 'provides' => $provided_views);
  }

  function getProtocols(){ 
    global $provided_protocols;
    global $accepted_protocols;
    return array('accepts' => $accepted_protocols,
		 'provides' => $provided_protocols);
  }

  function getProperties(){ 
    global $provided_properties;
    return array('accepts' => null,
		 'provides' => $provided_properties,
		 'contains' => $provided_properties);
  }

  function listNodes($node_request) {
    // get uri to list
    // need to parse this for cleanliness at some point
    // (trailing slashes, etc.)
    $uri = $node_request->nodes->node->uri;

    $token=null;
    $limit=False;
    $detail='min';

    if($node_request->token)
      $token = $node_request->token;
    if($node_request->limit)
      $limit = $node_request->limit;
    if($node_request->detail)
      $detail = $node_request->detail;

    $node_list = array('detail' => $detail,
		       'nodes' => array());

    $path = str_replace( VOSPACE_ROOT, FILE_SYSTEM_ROOT, $uri );
    //    error_log(var_export($path.'\n', True), 3, "/var/tmp/my-errors.log");
    // quick check to see if this is a single file
    if(is_file($path)){
      $node_uri = str_replace( FILE_SYSTEM_ROOT, VOSPACE_ROOT,  $path );

      $new_node = new Node($node_uri);
      if($detail != 'min')
	$new_node->populateProperties();
      $node_list['nodes'][0] = $new_node;
    }else{

      // look for wildcards and trailing slashes
      if( strpos($path, "*") === FALSE &&
	  $path[strlen($path) - 1] != '/' ){
	$path = $path . "/*";
      }

      $i = 0;
      foreach (glob($path) as $filename) {
	$file = basename($filename);      
	if ($file != "." && $file != ".." && $file != ".svn") {
	  $node_uri = str_replace( FILE_SYSTEM_ROOT, VOSPACE_ROOT,  $filename );
	  
	  $new_node = new Node($node_uri);
	  if($detail != 'min')
	    $new_node->populateProperties();
	  $node_list['nodes'][$i++] = $new_node;
	}
      }
    }    
    
    if(count($node_list['nodes']) == 0)
      unset($node_list['nodes']);
  
    return $node_list;
  }

}

?>
