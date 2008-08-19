<?php 

require_once('config.inc');

require_once(BACKEND.'node.php');
require_once(BACKEND.'vospace.php');

class VOSpaceService { 

  function GetViews($message)
  { 

    return $data;

  }

  function GetProtocols($message)
  { 

    return $data;

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

  function ListNodes($message){
    $data = array("response"=>array("token" => "foo", "limit" => 100, "detail" => "min", "nodes"=> array()));
    return $data;
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

    return $data; 

  }

} 

?>
