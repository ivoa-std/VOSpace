<?php

include('../config.inc');

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');


function barf($client) {
    print "<pre>\n";
    print "Request:\n".htmlspecialchars($client->__getLastRequest()) ."\n";
    print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n";
    print "</pre>"; 

    print "<pre>"; 
    print_r($client->__getTypes());
    print "</pre>"; 

}

function barf_min($client) {
    print "<pre>\n";
    print "Request:\n".htmlspecialchars($client->__getLastRequest()) ."\n";
    print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n";
    print "</pre>"; 
}

function barf_var($var) {
    print "<pre>\n";
    var_dump($var);
    print "</pre>"; 
}

class TestVOSpaceServiceEndpoint extends UnitTestCase {
  function TestVOSpaceServiceEndpoint() {
    $this->UnitTestCase();

  }

  function setUp(){
    $this->client = new
      SoapClient(
		 "../vospace.wsdl",
		 array('location' => 'http://localhost/vospace/vospace_endpoint.php',
		       'uri' => 'http://www.ivoa.net/xml/VOSpaceContract-v1.1rc1',
		       "trace"      => 1,
		       "exceptions" => 1));

  }

  function testNewServiceEndpoint() {
    
    $this->assertNotNull($this->client);
  }
  
  function testFunctionsList() {

    $function_list = $this->client->__getFunctions();
    $this->assertEqual(count($function_list), 15);
  }

  function testGetProperties() {
    
    $response = $this->client->GetProperties();
         print "<pre>";     
         var_dump($response);
         print "</pre>"; 
         barf($this->client);

    $accepts = $response->accepts;
    $provides = $response->provides;
    $contains = $response->contains;

    $this->assertNotNull($accepts);
    $this->assertNotNull($provides);
    $this->assertNotNull($contains);  

    // hard coding the order to keep things simple
    $this->assertEqual($provides->property[0]->uri,
		       "ivo://net.ivoa.vospace/properties#size" );
    $this->assertEqual($provides->property[0]->readonly, True);

    $this->assertEqual($provides->property[1]->uri,
		       "ivo://net.ivoa.vospace/properties#owner" );
    $this->assertEqual($provides->property[1]->readonly, True);

    $this->assertEqual($provides->property[2]->uri,
		       "ivo://net.ivoa.vospace/properties#modificationdate" );
    $this->assertEqual($provides->property[2]->readonly, True);

    $this->assertEqual($provides->property[3]->uri,
		       "ivo://net.ivoa.vospace/properties#creationdate" );
    $this->assertEqual($provides->property[3]->readonly, True);

    //     print "<pre>";     
    //     var_dump($provides);
    //     print "</pre>"; 
    //     barf($this->client);
  }


  function testNodeNotFound() {

     try { 
       $response = $this->client->GetNode(array("target" => 'vos://foo.bar.baz!bang'));
     }
     catch (SoapFault $exp) { 
       $this->assertEqual($exp->detail->NodeNotFoundFault->uri, 'vos://foo.bar.baz!bang' );
     }
 
    //barf($this->client);
  }

  function testGetNode() {
    
    $response = $this->client->GetNode(array("target" => 'vos://exmple.org!vospace/foo.txt'));
    $node = $response->node;
    $properties = $response->properties;

    $this->assertEqual($node->uri, 'vos://exmple.org!vospace/foo.txt' );

    $this->assertNotNull($node->properties);
	      
    $this->assertEqual($node->properties->property[0]->uri,
		       "ivo://net.ivoa.vospace/properties#size" );
    $this->assertEqual($node->properties->property[0]->readonly, True);

    $this->assertEqual($node->properties->property[0]->_, "1");

    $this->assertEqual($node->properties->property[1]->uri,
		       "ivo://net.ivoa.vospace/properties#owner" );
    $this->assertEqual($node->properties->property[1]->readonly, True);

    $this->assertEqual($node->properties->property[2]->uri,
		       "ivo://net.ivoa.vospace/properties#modificationdate" );
    $this->assertEqual($node->properties->property[2]->readonly, True);

    $this->assertEqual($node->properties->property[3]->uri,
		       "ivo://net.ivoa.vospace/properties#creationdate" );
    $this->assertEqual($node->properties->property[3]->readonly, True);

    //barf_min($this->client);
  }

  function testListNodes() {
    
    $this->client->ListNodes();
  }
}

$test = &new TestVOSpaceServiceEndpoint();
$test->run(new HtmlReporter());

?>
