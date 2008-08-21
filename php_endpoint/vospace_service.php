<?php 

require_once('config.inc');

require_once(BACKEND.'node.php');
require_once(BACKEND.'vospace.php');


class VOSpaceService { 

  function GetViews($message){ 
    $vospace = new VOSpace();
    $views = $vospace->getViews();
    return $views;
  }

  function GetProtocols($message){     
    $vospace = new VOSpace();
    $protocols = $vospace->getProtocols();
    return $protocols;
  }

  function GetProperties(){ 
    $vospace = &new VOSpace();
    $properties = $vospace->getProperties();
    return $properties;
  }

  function CreateNode($message)
  { 

    return $data; 

  }

  function DeleteNode($message)
  { 

    return $data; 

  }

  function MoveNode($message)
  { 

    return $data;

  }

  function CopyNode($message)
  { 


    return $data;

  }

  function GetNode($target)
  { 

    $node = new Node($target->target);
    
    if(!$node->exists()){
      $bad_target = $target->target;
      throw new SoapFault("Server", "Node not found.", " ",
			  array("uri" => $bad_target),
			  "NodeNotFoundFault");
    }

    $node->populateProperties();
    return array('node' => $node);
  }

  function SetNode($message)
  { 


    return $data; 

  }

  function ListNodes($node_list_req){

    $vospace = &new VOSpace();
    //    error_log(var_export($node_list_req, True), 3, "/var/tmp/my-errors.log");
    $node_list = $vospace->listNodes($node_list_req->request);

    if($node_list['nodes'] == Null){
      throw new SoapFault("Server", "Node not found.", " ",
			  array("uri" => $node_list_req->request->nodes->node->uri),
			  "NodeNotFoundFault");
    }

    return array('response' => $node_list);
  }

  function FindNodes($message)
  { 

    return $data; 

  }

  function PushToVoSpace($message)
  { 

    return $data; 

  }

  function PullToVoSpace($message)
  { 

    return $data; 

  }

  function PullFromVoSpace($request)
  { 
    $node = new Node($request->source);
    
    if(!$node->exists()){
      $bad_target = $request->source;
      throw new SoapFault("Server", "Node not found.", " ",
			  array("uri" => $bad_target),
			  "NodeNotFoundFault");
    }

    $view = $node->getView();
    $protocols = $node->getProtocols();

    // transfer element, with at least a view and protocol element
    $response = array('transfer'=> 
		      array('view' => $view,
			    'protocol' => $protocols));

    return $response;
  }

  function PushFromVoSpace($message){ 
      throw new SoapFault("Server", "Not implemented.", " ",
			  array(),
			  "InternalFault");
  }

  function Security( $foo ){

    $p = xml_parser_create();
    xml_parse_into_struct($p, $foo->any, $vals, $index);
    xml_parser_free($p);
//     error_log(var_export($vals, True), 3, "/var/tmp/vospace.err.log");
//     error_log(var_export($index, True), 3, "/var/tmp/vospace.err.log");

    $username = '';
    $password = '';
    foreach( $vals as $element){
      if( strpos($element['tag'],  "USERNAMETOKEN") === FALSE ){
	if( strpos($element['tag'],  "USERNAME") !== FALSE )
	  $username = $element['value'];
	if( strpos($element['tag'],  "PASSWORD") !== FALSE )
	  $password = $element['value'];
      }
    }
    error_log(var_export($username, True), 3, "/var/tmp/vospace.err.log");
    error_log(var_export($password, True), 3, "/var/tmp/vospace.err.log");

    if( $username == 'joe' && $password == 'doe' ){
      $this->Authenticated = True;
    } else {
      $this->Authenticated = False;
       throw new SoapFault("Server", "Not authenticated.", " ",
			   array(),
			   "PermissionDeniedFault");
      
    }
  }
} 

?>
