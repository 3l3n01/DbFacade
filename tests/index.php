<?php
namespace DbAdapters\Tests;

require_once 'config.php';
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
echo "<h2>", get_class($adapter), "</h2>\n";

echo "<pre>";
try {  // ================= Testing area ====================

$sql = 'SELECT
id,
word
FROM sample_words
WHERE 1
LIMIT 4';

foreach($words as $w) {
    print_r($w);
}
#print_r($words);
echo "</pre>";
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
