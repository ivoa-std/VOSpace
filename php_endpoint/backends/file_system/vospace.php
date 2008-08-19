<?php

require_once(BACKEND.'config.backend.inc');
require_once(BACKEND.'properties.php');
require_once(BACKEND.'node.php');

class VOSpace {

  function getProperties(){ 
    global $provided_properties;
    return array('accepts' => null,
		 'provides' => $provided_properties,
		 'contains' => null);
  }

  function listNodes($node_request) {

    // get uri to list
    // need to parse this for cleanliness at some point
    // (trailing slashes, etc.)
    $uri = $node_request['nodes'][0]['uri'];

    $token=null;
    $limit=False;
    $detail='min';
    
    if(array_key_exists('token', $node_request))
      $token = $node_request['token'];
    if(array_key_exists('limit', $node_request))
      $token = $node_request['limit'];
    if(array_key_exists('detail', $node_request))
      $token = $node_request['detail'];

    // Null for nodes indicates path not found
    $node_list = array('nodes' => Null,
		       'detail' => $detail);

    $dir_path = str_replace( VOSPACE_ROOT, FILE_SYSTEM_ROOT, $uri );
    //     $node_list['dir'] = $dir_path;
    //     $node_list['uri'] = $uri;
    //     $node_list['req'] = $node_request;

    if ($handle = opendir($dir_path)) {
      // empty array for nodes indicates path found,
      // but no child nodes
      $node_list['nodes'] = array();
      $i = 0;
      while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != ".svn") {

	  $node_uri = str_replace( FILE_SYSTEM_ROOT, VOSPACE_ROOT.'/',  $file);
	  
	  $node_list['nodes'][$i++] = &new Node($node_uri);
	  if($detail != 'min')
	    $node_list['nodes'][$i]->populateProperties();
        }
      }
      closedir($handle);
    }
    
    return $node_list;
  }
}

?>
