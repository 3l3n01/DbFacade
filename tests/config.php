<?php
namespace DbAdapters\Tests;

require_once '../vendor/autoload.php';
require_once 'src/functions.php';

use \DbAdapters\DatabaseAdapterAbstract;


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
$adodb_adapter    = DatabaseAdapterAbstract::factory($adodb_mysql_conn);

$pdo_mysql_conn   = getPdoConnection("mysql", $db_host, $db_name, $db_user, $db_pass, 'utf8', 'pconnect');
$pdo_adapter      = DatabaseAdapterAbstract::factory($pdo_mysql_conn);

$adapters = array($adodb_adapter, $pdo_adapter);

