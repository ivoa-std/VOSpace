<?php

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

?>
