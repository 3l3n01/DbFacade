<?php
namespace DbFacade\Tests;

require_once './src/functions.php';
require_once '../vendor/autoload.php';

use \DbFacade\DatabaseFacadeAbstract;


/****************************************
 *
 * Setup mockup database connection
 *
 ****************************************/
$db_driver = 'mysql';
$db_host   = 'localhost';
$db_name   = 'NewFreetag';
$db_user   = 'root';
#$db_pass   = 'buropa19';
$db_pass   = 'kiranu49';



$adodb_mysql_conn = getDatabaseADOConnection("mysql", $db_host, $db_name, $db_user, $db_pass, 'utf8', 'pconnect');
$adodb_adapter    = DatabaseFacadeAbstract::factory($adodb_mysql_conn);

$pdo_mysql_conn   = getPdoConnection("mysql", $db_host, $db_name, $db_user, $db_pass, 'utf8', 'pconnect');
$pdo_adapter      = DatabaseFacadeAbstract::factory($pdo_mysql_conn);

$facades = array($adodb_adapter, $pdo_adapter);

