<?php
namespace NewFreetag\Tests;

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

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NewFreetag | Test suite</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<h1>DbAdapters Test</h1>
<?php

try {  // ================= Testing area ====================

$adodb_mysql_conn = getDatabaseADOConnection("mysql", $db_host, $db_name, $db_user, $db_pass, 'utf8', 'pconnect');
$adodb_adapter    = DatabaseAdapterAbstract::factory($adodb_mysql_conn);

$pdo_mysql_conn   = getPdoConnection("mysql", $db_host, $db_name, $db_user, $db_pass, 'utf8', 'pconnect');
$pdo_adapter      = DatabaseAdapterAbstract::factory($pdo_mysql_conn);

$adapters = array($adodb_adapter, $pdo_adapter);

echo "Moin";
echo pre_r( $pdo_adapter->query("SELECT word FROM sample_words WHERE 1 LIMIT 0,25")->getRows());
echo "<hr>";

?>

<?php
// ================= Catching testing exceptions  ====================
}
catch (\Exception $e) {
    echo '<div class="exception"><b>', get_class($e), ": </b>",
    $e->getMessage(),       "<br />",
    $e->getTraceAsString(), "</div>\n";
}
?>
</body>
</html>
