<?php

include('../config.inc');
// ini_set('soap.wsdl_cache_enabled', 0);
require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once('debug_funcs.php');

class UsernameT1 { 
  private $Username; //Name must be identical to corresponding XML tag in SOAP header 
  private $Password; // Name must be identical to corresponding XML tag in SOAP header 
  function __construct($username, $password) { 
    $this->Username=$username; 
    $this->Password=$password; 
  } 
} 

class UserNameT2 { 
  private $UsernameToken; //Name must be identical to corresponding XML tag in SOAP header 
  function __construct ($innerVal){ 
    $this->UsernameToken = $innerVal; 
  } 
} 

function get_header($username = 'joe', $password = 'doe'){

    $nameSpace = "http://schemas.xmlsoap.org/ws/2003/06/secext"; //WS-Security namespace 
    $userT = new SoapVar($username, XSD_STRING, NULL, $nameSpace, NULL, $nameSpace); 
    $passwT = new SoapVar($password, XSD_STRING, NULL, $nameSpace, NULL, $nameSpace);

    $tmp = new UsernameT1($userT, $passwT); 
    $uuT = new SoapVar($tmp, SOAP_ENC_OBJECT, NULL, $nameSpace, 
		       'UsernameToken', $nameSpace); 

    $tmp = new UsernameT2($uuT); 
    $userToken = new SoapVar($tmp, SOAP_ENC_OBJECT, NULL, $nameSpace, 'UsernameToken', 
			     $nameSpace);
    $secHeaderValue=new SoapVar($userToken, SOAP_ENC_OBJECT, NULL, $nameSpace, 'Security', 
				$nameSpace);  
    return new SoapHeader($nameSpace, 'Security', $secHeaderValue);

}

class TestVOSpaceAuthorization extends UnitTestCase {

  function setUp(){

    $this->secHeader = get_header();
    $this->client = new
      SoapClient('../vospace.wsdl',
		 array('location' => 'http://localhost/vospace/vospace_endpoint.php',
		       'uri' => 'http://www.ivoa.net/xml/VOSpaceContract-v1.1rc1',
		       'trace'      => 1,
		       'exceptions' => 1));

  }
  
  function testGetProtocolsAuth() {
    $this->client->__setSoapHeaders($this->secHeader);
    $response = $this->client->GetProtocols();
    // barf($this->client);
    
    $accepts = $response->accepts;
    $provides = $response->provides;

    $this->assertNotNull($accepts);

    $this->assertEqual($provides->protocol[0]->uri,
		       'ivo://net.ivoa.vospace/protocols#http-client');
  }

  function testGetProtocols() {
    $response = $this->client->GetProtocols();
    // barf($this->client);    
     $accepts = $response->accepts;
     $provides = $response->provides;

     $this->assertNotNull($accepts);

     $this->assertEqual($provides->protocol[0]->uri,
 		       'ivo://net.ivoa.vospace/protocols#http-client');
   }

  function testGetProtocolsCompare() {
    $response_auth = $this->client->__soapCall('GetProtocols', array('GetProtocols'=>Null), 
					       null, $this->secHeader ); 
    $response = $this->client->GetProtocols();
    
    $this->assertEqual($response_auth, $response);
  }

  function testUnauthorized(){
         try { 
	   $this->secHeader = get_header('jon', 'don');

	   $response_auth = $this->client->__soapCall('GetProtocols', array('GetProtocols'=>Null), 
						      null, $this->secHeader ); 

	   $this->assertTrue(0, "Should have thrown not authenticated.");
     }
     catch (SoapFault $exp) { 
       $this->assertEqual($exp->faultstring, "Not authenticated.");
     }

  }
}

$test = new TestVOSpaceAuthorization();
$test->run(new HtmlReporter());

?>
