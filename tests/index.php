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
// returns concretion of \DbFacade\QueryResultAbstract
$records = $facade->read( 'SELECT * FROM words WHERE id = :what', array(
    ':what' => $search
));
</pre>
    </dd>
    <dt>CREATE</dt>
    <dd><pre class="prettyprint linenums">
// returns last insert ID
$new_id = $facade->create( 'INSERT INTO words (word) VALUES (:new)', array(
    ':new' => "Foo"
));
</pre>
    </dd>
    <dt>UDPATE</dt>
    <dd><pre class="prettyprint linenums">
// returns number of affected rows
$affected = $facade->update( 'UPDATE words SET word = :value WHERE 1', array(
    ':value' => "Bar"
));
</pre>
    </dd>
    <dt>DELETE</dt>
    <dd><pre class="prettyprint linenums">
// returns number of affected rows
$gone = $facade->delete( 'DELETE FROM words WHERE id = :vanish', array(
    ':vanish' => $id
));
</pre>
    </dd>
</dl>

<h2>Instantiation</h2>
<p>Let's say you've got a <code>PDOConnection</code> or <code>ADOConnection</code> object.
To get your concretion of <tt>DatabaseFacadeAbstract</tt>, simply pass to the <code>factory</code> method.
If you pass something that <samp>factory</samp> can not cope with,
an <samp>\InvalidArgumentException</samp> will tell you.</p>

<?php
pretty_print('&lt;?php
namespace \MyApp;
use \DbFacade\DatabaseFacadeAbstract;

// $pdo_mysql_conn: Any PDOConnection
$facade = DatabaseFacadeAbstract::factory( $pdo_mysql_conn );
echo get_class( $facade ); // DbFacade\PdoFacade

// $ado_mysql_conn: Any ADOConnection
$facade = DatabaseFacadeAbstract::factory( $ado_mysql_conn );
echo get_class( $facade ); // DbFacade\AdoDbFacade
?&gt;');
?>



<p>DbFacade in test:</p>
<ul>
<?php
foreach($facades as $index => $facade):
    echo '<li><a href="#', $index, '">', get_class($facade), "</a></li>\n";
endforeach;
?>
</ul>

<?php
foreach($facades as $index => $facade):
echo '<h2 id="' . $index . '">', get_class($facade), "</h2>\n";

try {  // ================= Testing area ====================



echo "<h3>Selects</h3>\n";

$select = 'SELECT
*
FROM words
WHERE 1
LIMIT 4';

pretty_print($select);

$words = $facade->read( $select );
echo "<pre>";
foreach($words as $w) { print_r( $w ); }
echo "</pre>";
echo "<hr>";




echo "<h3>Inserts</h3>\n";
$max = 10;
$insert = 'INSERT INTO words
( word )
VALUES
( :word )';

echo "Running ", $max, " &times ";
pretty_print( $insert );

echo "<pre>";
for ($i = 0; $i < 10; $i++):
    $insert_id = $facade->create( $insert, array(
        ':word' => "Hallo"
    ));
    echo $insert_id, " ";
endfor;
echo "</pre>";
echo "<hr>";





echo "<h3>Updates</h3>\n";
$update = 'UPDATE words
SET random = RAND()
WHERE id BETWEEN 3 and 7';

pretty_print( $update );

$result = $facade->update( $update);
echo "<pre>";
var_dump($result);
echo "</pre>";
echo "<hr>";




echo "<h3>Deletions</h3>\n";
$delete = 'DELETE FROM words
WHERE id > (:newest - 5)
LIMIT 3';

pretty_print( $delete );

$result = $facade->delete( $delete, array(
    ':newest' => $insert_id
) );
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

endforeach; // Facedes foreach

require_once 'inc/html.outro.php';
