<?php

  // Replace the occurences of "my" stuff with relevant information
  // for your installation.

  // file path to PRODS
if (! defined('PRODS_ROOT')) {
  define('PRODS_ROOT', '/var/www/html/prods/src/');
 }

// IRODS login info
if (! defined('IRODS_SERVER')) {
  define('IRODS_SERVER', 'myServer.myGroup.org');
 }

// this is an integer
if (! defined('IRODS_PORT')) {
  define('IRODS_PORT', myPort);
 }

if (! defined('IRODS_USER')) {
  define('IRODS_USER', 'myUser');
 }

if (! defined('IRODS_PASS')) {
  define('IRODS_PASS', 'myPass');
 }

if (! defined('IRODS_ZONE')) {
  define('IRODS_ZONE', 'myZone');
 }

if (! defined('IRODS_HOME')) {
  define('IRODS_HOME', '/myZone/home/myUser');
 }

// provide a mapping between the endpoint, and a
// collection in IRODS

if (! defined('VOSPACE_ROOT')) {
  define('VOSPACE_ROOT', 'vos://example.org!vospace');
 }

if (! defined('IRODS_ROOT')) {
  define('IRODS_ROOT', '/myZone/home/myuser');
 }


// File path to simpletest, needed to run unit tests
if (! defined('SIMPLE_TEST')) {
  define('SIMPLE_TEST', '/var/www/html/simpletest/');
 }

?>