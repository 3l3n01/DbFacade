<?php
namespace DbFacade\Tests;
require_once 'config.php';
require_once 'inc/html.intro.php';
?>

<div class="page-header">
  <h1>DbFacade <small>gives you what you are really interested in</small></h1>
</div>

<div class="lead">
    <p>When talking to databases, this is what we are after:</p>
    <ul>
    <li>When you <code>SELECT</code> something, you are interested in records.</li>
    <li>After <code>INSERTING</code>, it's the new ID you are after,</li>
    <li>when <code>UPDATE</code>ing or <code>DELETE</code>ing, the number of affected rows.</li>
    </ul>

    <p>DbFacade provides a simple method API.</p>
</div>

<hr />
<h2>Overview</h2>

<dl>
    <dt>SELECT</dt>
    <dd>
    <pre class="prettyprint linenums">
$records = $facade->read( 'SELECT * FROM table WHERE id = :what', array(
    ':what' => $search
));
</pre>
    </dd>
    <dt>CREATE</dt>
    <dd><pre class="prettyprint linenums">
$new_id = $facade->create( 'INSERT INTO table (field) VALUES (:new)', array(
    ':new' => "Foo"
));
</pre>
    </dd>
    <dt>UDPATE</dt>
    <dd><pre class="prettyprint linenums">
$affected = $facade->update( 'UPDATE table SET field = :value WHERE 1', array(
    ':value' => "Bar"
));
</pre>
    </dd>
    <dt>DELETE</dt>
    <dd><pre class="prettyprint linenums">
$away = $facade->delete( 'DELETE FROM table WHERE id = :vanish', array(
    ':vanish' => $id
));
</pre>
    </dd>
</dl>

<h2>Instantiation</h2>
<p>Let's say you've got a <code>PDOConnection</code> or <code>ADOConnection</code> object.
To get your concretion of <tt>DatabaseAdapterAbstract</tt>, simply pass to the <code>factory</code> method.
If you pass something that <samp>factory</samp> can not cope with,
an <samp>\InvalidArgumentException</samp> will tell you.</p>

<pre class="prettyprint linenums">
&lt;?php
namespace \MyApp;
use \DbFacade\DatabaseAdapterAbstract;

// $pdo_mysql_conn: Any PDOConnection
$adapter = DatabaseAdapterAbstract::factory( $pdo_mysql_conn );
echo get_class( $adapter ); // DbFacade\PdoAdapter

// $ado_mysql_conn: Any ADOConnection
$adapter = DatabaseAdapterAbstract::factory( $ado_mysql_conn );
echo get_class( $adapter ); // DbFacade\AdoDbAdapter
?&gt;
</pre>

<p>DbFacade in test:</p>
<ul>
<?php
foreach($adapters as $index => $adapter):
    echo '<li><a href="#', $index, '">', get_class($adapter), "</a></li>\n";
endforeach;
?>
</ul>

<?php
foreach($adapters as $index => $adapter):
echo '<h2 id="' . $index . '">', get_class($adapter), "</h2>\n";

try {  // ================= Testing area ====================



$select = 'SELECT
id,
word
FROM sample_words
WHERE 1
LIMIT 4';

echo "$select<br />";

$words = $adapter->read( $select );
echo "<pre>";
foreach($words as $w) { print_r( $w ); }
echo "</pre>";
echo "<hr>";





$insert = 'INSERT INTO sample_words
(word) VALUES ( :word )';
echo "$insert<br />";

$result = $adapter->create( $insert, array(
    ':word' => "Hallo"
));
echo "<pre>";
var_dump($result);
echo "</pre>";
echo "<hr>";






$update = 'UPDATE sample_words
SET word = RAND()
WHERE id BETWEEN 40 and 44';
echo "$update<br />";

$result = $adapter->update( $update);
echo "<pre>";
var_dump($result);
echo "</pre>";
echo "<hr>";





$delete = 'DELETE FROM sample_words
WHERE id BETWEEN 50 and 52';
echo "$delete<br />";

$result = $adapter->delete( $delete);
echo "<pre>";
var_dump($result);
echo "</pre>";
echo "<hr>";



// ================= Catching testing exceptions  ====================
}
catch (\Exception $e) {
    echo '<div class="exception"><b>', get_class($e), ": </b>",
    $e->getMessage(),       "<br />",
    $e->getTraceAsString(),
    "</div><!-- /.exception -->\n";
}

endforeach; // Adapters foreach

require_once 'inc/html.outro.php';
