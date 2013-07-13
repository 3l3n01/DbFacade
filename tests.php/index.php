<?php
namespace NewFreetag\Tests;

require_once '../config.php';

use \NewFreetag\Freetag;
use \NewFreetag\Tag;
use \NewFreetag\Collections\ParsedTagsCollection;
use \DbAdapters\DatabaseAdapterAbstract;


/****************************************
 *
 * Setup mockup Twig Template engine
 *
 ****************************************/
$loader = new \Twig_Loader_Filesystem('../templates');
$twig   = new \Twig_Environment($loader, array(
    'debug' => true,
    'cache' => 'var/cache',
));



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

echo "Moin";
echo pre_r( $pdo_adapter->query("SELECT word FROM sample_words WHERE 1 LIMIT 0,25")->getRows());
echo "<hr>";

$context1 = array(
    ':tag_id' => 1
);
$sql_select1 = 'SELECT * from freetags WHERE id > :tag_id LIMIT 2';
foreach($adapters as $adapter) {
    echo "<h4>" . get_class($adapter) . "</h4>\n";
    echo "<code>$sql_select1</code><br>";

    $query_result = $adapter->query( $sql_select1, $context1 );
    $q2 = $query_result->getRows();
    echo "Ergebnis: ", $query_result->count();


    echo "<h5>foreach1</h5>\n";
    foreach($query_result as $index => $data) {
        echo $index, "/", $query_result->count(),  pre_r($data), "<br />";
        #echo $index, "<br />";
    }

    echo "<h5>foreach2</h5>\n";
    foreach($q2 as $index => $data) {
        echo $index, "/", $q2->count(),  pre_r($data), "<br />";
        #echo $index, "<br />";
    }

    echo "<hr>";
}


$context2 = array(
    ':norm_tag' => "gramm",
    ':raw_tag' => "Gramm"
);
$sql_select2 = 'INSERT INTO freetags (tag, raw_tag) VALUES (:norm_tag, :raw_tag)';
foreach($adapters as $adapter) {
    echo "<h4>" . get_class($adapter) . "</h4>\n";
    echo "<code>$sql_select2</code><br />";

    $query_result = $adapter->execute( $sql_select2, $context2 )->affectedRows();
    echo $query_result;
}




/****************************************
 *
 * Testing environment variables
 *
 ****************************************/

$empty_first = true;
#$empty_first = false;


/****************************************
 *
 * Constructor options
 *
 ****************************************/
$freetag_options = array(
    "debug" => true,
    "templating" => $twig,
    "db" => $adodb_mysql_conn,
    #"db" => $pdo_mysql_conn,
    "block_multiuser_tag_on_object" => false,
    "moin"=>"hallo",
    "append_to_integer" => false,
    #"table_prefix"=>"wrong_pre$adofix"
);
# $freetag_options = array();  # no options
# $freetag_options = "wrong";  # wrong options type


// The ID of the assumed tagging subject
$tagger_id = 1;

// The ID of object to be tagged
$object_id = 106;


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
<h1>New Freetag</h1>
<?php

try {  // ================= Testing area ====================

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
