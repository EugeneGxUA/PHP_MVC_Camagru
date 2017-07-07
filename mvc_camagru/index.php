<?php
/*require "components/Session.php";*/


/* ==       Front Controller        == */


/* ==  Settings (errors)  == */
/*error_reporting(-1);
ini_set('display_errors','on');*/

//error_reporting(E_ALL);
//ini_set('display_errors','on');

/* ==  System Files Connection  == */

define('ROOT', getcwd());
require_once (ROOT.'/components/Router.php');
require_once (ROOT.'/components/Session.php');


/* ==  Connect to DB  == */

require_once (ROOT.'/components/Db.php');

/*  ==  Create DB and Table  ==  */

Db::createDB();
Db::createTable();
/*require_once (ROOT.'/components/Session.php');*/



/*  == Call Router ==  */

$router = new Router();
$router->run();
