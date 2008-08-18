<?php

// provide a mapping between the endpoint, and a
// collection in IRODS
if (! defined('VOSPACE_ROOT')) {
  define('VOSPACE_ROOT', 'ivo://example.org!vospace');
 }

// File path to simpletest, needed to run unit tests
if (! defined('SIMPLE_TEST')) {
  define('SIMPLE_TEST', '/var/www/vos/simpletest/');
 }

// Relative file path to backend being used
if (! defined('BACKEND')) {
  define('BACKEND', '/var/www/vos/vospace/backends/file_system/');
 }

?>