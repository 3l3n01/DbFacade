<?php
namespace DbAdapters\Tests;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DbAdapters | Test suite</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<h1>DbAdapters Test</h1>
<?php
foreach($adapters as $adapter):
    echo "<h3>", get_class($adapter), "</h3>\n";

try {  // ================= Testing area ====================

$sql = "SELECT word FROM sample_words WHERE 1 LIMIT 0,3";
$words = $adapter->query("SELECT word FROM sample_words WHERE 1 LIMIT 0,3")->getRows();
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

endforeach; // Adapters
?>
</body>
</html>
