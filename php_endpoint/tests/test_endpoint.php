<?php

include('../config.inc');

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once('debug_funcs.php');

class TestVOSpaceServiceEndpoint extends UnitTestCase {

  function setUp(){
    $this->client = new
      SoapClient(
		 '../vospace.wsdl',
		 array('location' => 'http://localhost/vospace/vospace_endpoint.php',
		       'uri' => 'http://www.ivoa.net/xml/VOSpaceContract-v1.1rc1',
		       'trace'      => 1,
		       'exceptions' => 1));

  }

  function testNewServiceEndpoint() {
    
    $this->assertNotNull($this->client);
  }
  
  function testFunctionsList() {

    $function_list = $this->client->__getFunctions();
    $this->assertEqual(count($function_list), 15);
  }


  function testGetProtocols() {
    
    $response = $this->client->GetProtocols();
    
    $accepts = $response->accepts;
    $provides = $response->provides;

    $this->assertNotNull($accepts);
    $this->assertNotNull($provides);

    $this->assertEqual($provides->protocol[0]->uri,
		       'ivo://net.ivoa.vospace/protocols#http-client');
    $this->assertEqual($accepts->protocol[1]->uri,
		       'ivo://net.ivoa.vospace/protocols#http-server');
  }


  function testGetViews() {
    
    $response = $this->client->GetViews();
    
    $accepts = $response->accepts;
    $provides = $response->provides;

    $this->assertNotNull($accepts);
    $this->assertNotNull($provides);

    // the 'view' array only has a single element,
    // so there's no indexing on it
    $this->assertEqual($provides->view->uri,
		       'ivo://net.ivoa.vospace/views#identity');
    $this->assertEqual($accepts->view->uri,
		       'ivo://net.ivoa.vospace/views#identity');
  }

  function testGetProperties() {
    
    $response = $this->client->GetProperties();
    
    $accepts = $response->accepts;
    $provides = $response->provides;
    $contains = $response->contains;

    $this->assertNotNull($accepts);
    $this->assertNotNull($provides);
    $this->assertNotNull($contains);  

    // hard coding the order to keep things simple
    $this->assertEqual($provides->property[0]->uri,
		       'ivo://net.ivoa.vospace/properties#size' );
    $this->assertEqual($provides->property[0]->readonly, True);

    $this->assertEqual($provides->property[1]->uri,
		       'ivo://net.ivoa.vospace/properties#owner' );
    $this->assertEqual($provides->property[1]->readonly, True);

    $this->assertEqual($provides->property[2]->uri,
		       'ivo://net.ivoa.vospace/properties#modificationdate' );
    $this->assertEqual($provides->property[2]->readonly, True);

    $this->assertEqual($provides->property[3]->uri,
		       'ivo://net.ivoa.vospace/properties#creationdate' );
    $this->assertEqual($provides->property[3]->readonly, True);

    //     print '<pre>';     
    //     var_dump($provides);
    //     print '</pre>'; 
    //     barf($this->client);
  }


  function testNodeNotFound() {

     try { 
       $response = $this->client->GetNode(array('target' => 'ivo://example.org!vospace/foo.txt'));
       $this->assertTrue(0, "Should have thrown NodeNotFound");
     }
     catch (SoapFault $exp) { 
       $this->assertEqual($exp->detail->NodeNotFoundFault->uri, 'ivo://example.org!vospace/foo.txt' );
     }
 
  }

  function testGetNode() {
    
    $response = $this->client->GetNode(array('target' => 'ivo://example.org!vospace/128cubed_hierarchy.png'));
    $node = $response->node;
    $properties = $response->properties;

    $this->assertEqual($node->uri, 'ivo://example.org!vospace/128cubed_hierarchy.png' );

    $this->assertNotNull($node->properties);
	      
    $this->assertEqual($node->properties->property[0]->uri,
		       'ivo://net.ivoa.vospace/properties#size' );
    $this->assertEqual($node->properties->property[0]->readonly, True);

    $this->assertEqual($node->properties->property[0]->_, '569516');

    $this->assertEqual($node->properties->property[1]->uri,
		       'ivo://net.ivoa.vospace/properties#owner' );
    $this->assertEqual($node->properties->property[1]->readonly, True);

    $this->assertEqual($node->properties->property[2]->uri,
		       'ivo://net.ivoa.vospace/properties#modificationdate' );
    $this->assertEqual($node->properties->property[2]->readonly, True);

    $this->assertEqual($node->properties->property[3]->uri,
		       'ivo://net.ivoa.vospace/properties#creationdate' );
    $this->assertEqual($node->properties->property[3]->readonly, True);

    //barf_min($this->client);
  }

  function testPullFromNodeNotFound() {

     try { 
       $response = $this->client->PullFromVoSpace(array('source' =>
							'ivo://example.org!vospace/foo.txt',
							'transfer' => Null));
       $this->assertTrue(0, "Should have thrown NodeNotFound");
     }
     catch (SoapFault $exp) { 
       $this->assertEqual($exp->detail->NodeNotFoundFault->uri, 'ivo://example.org!vospace/foo.txt' );
     } 
  }

  function testPullFrom() {

    $view = array('uri' => 'ivo://net.ivoa.vospace/views#identity',
		  'original'=>True);
    $protocol = array('uri' => 'ivo://net.ivoa.vospace/protocols#http-client');

    $request = array('source' =>
		     'ivo://example.org!vospace/bill_of_rights.txt',
		     'transfer' => array('view'=> $view,
					 'protocol' => $protocol));

    $response = $this->client->PullFromVoSpace($request);
    $this->assertNotNull($response->transfer);

    $endpoint = $response->transfer->protocol->endpoint;

    // now we're going to check that the endpoint is
    // really there
    $this->assertTrue(url_exists($endpoint));
    
  }

  function testListNodesNodeNotFound() {    
    $request = array('request' => 
		     array('detail' => 'min',
			   'nodes' => 
			   array(array('uri' => 'ivo://example.org!vospace/moo'))));

    try {
      $response = $this->client->ListNodes($request);
      $this->assertTrue(0, "Should have thrown NodeNotFound");
    } catch (SoapFault $exp) { 
      $this->assertEqual($exp->detail->NodeNotFoundFault->uri, 'ivo://example.org!vospace/moo' );
    }

  }

  function testListNodes() {
    
    $request = array('request' => 
		     array('detail' => 'min',
			   'nodes' => 
			   array(array('uri' => 'ivo://example.org!vospace'))));

    $response = $this->client->ListNodes($request);
    // crazy example of how to march down the object
    // the name of the array is actually "node"
    //     barf_var($response);
    //     barf_var($response->response);
    //     barf_var($response->response->nodes);
    //     barf_var($response->response->nodes->node);
    //barf_var($response->response->nodes->node[0]);
    
    $this->assertEqual(count($response->response->nodes->node), 4);
  }

  function testListNodesContainer() {
    $request = array('request' => 
		     array('detail' => 'min',
			   'nodes' => 
			   array(array('uri' => 'ivo://example.org!vospace/images'))));

    $response = $this->client->ListNodes($request);
    
    $this->assertEqual(count($response->response->nodes->node), 3);

  }

   function testListNodesSingleNode() {
    $request = array('request' => 
		     array('detail' => 'min',
			   'nodes' => 
			   array(array('uri' => 'ivo://example.org!vospace/images/cl0041_0000_2_lxt_l7_pz.png'))));

    $response = $this->client->ListNodes($request);
    
    $this->assertEqual(count($response->response->nodes->node), 1);
    $this->assertEqual($response->response->nodes->node->uri,
		       'ivo://example.org!vospace/images/cl0041_0000_2_lxt_l7_pz.png');

   }

   function testListNodesWildcard() {
    $request = array('request' => 
		     array('detail' => 'min',
			   'nodes' => 
			   array(array('uri' => 'ivo://example.org!vospace/parameters/*0'))));

    $response = $this->client->ListNodes($request);
    
    $this->assertEqual(count($response->response->nodes->node), 2);

   }

   function testPushFrom() {
     
    try {
      $response = $this->client->PushFromVoSpace();
      $this->assertTrue(0, "Should have thrown InternalFault - Not implemented");
    } catch (SoapFault $exp) { 
      $this->assertEqual($exp->InternalFault, "");
    }

   }

}

$test = new TestVOSpaceServiceEndpoint();
$test->run(new HtmlReporter());

?>
