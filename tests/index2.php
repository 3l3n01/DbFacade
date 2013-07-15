<?php
namespace DbFacade\Tests;
require_once 'config.php';
?>
<h1>Moin</h1>


<pre>
<?php
foreach($adapters as $adapter):
echo "<h2>", get_class($adapter), "</h2>";

$adapter->execute('TRUNCATE TABLE freetags');


try {
	echo "<h4>INSERT</h4>";
	$insert = "INSERT INTO freetags
	(tag, raw_tag)
	VALUES (:tag2, NOW())";
	echo $insert, "\n";

	for ($i = 0; $i < 10; $i++) {
		$context = array(':tag2' => "moinmoin" . $i);
		$insert_id = $adapter->create($insert, $context);
		echo $insert_id, " ";
	}
}
catch (\Exception $e) {
	echo "<b>", get_class($e), "</b><br />", $e;
}
echo "<hr>";




try {
	echo "<h4>READ</h4>";
	$read = 'SELECT * FROM freetags WHERE 1 LIMIT 3';

	$context = array();

	echo $read, "\n";
	$selected = $adapter->read($read, $context);

	echo "MAGIC! call property directly: ", $selected->id, "\n";
	echo "MAGIC! call property via field method: ", $selected->field('raw_tag'), "\n";
	echo "MAGIC! call property via current(): ", $selected->current()->tag, "\n";

	foreach($selected as $row) {
		#echo $row->raw_tag;
		print_r($row);
	}
}
catch (\Exception $e) {
	echo "<b>", get_class($e), "</b><br />", $e;
}
echo "<hr>";



try {
	echo "<h4>UPDATE</h4>";
	$update = 'UPDATE freetags SET
	tag = NOW(),
	raw_tag = :raw_tag
	WHERE id < :id';

	$context = array(':raw_tag' => "Moin! Updated!", ':id' => ($insert_id - 5));

	echo $update, "\n";
	$updated = $adapter->update($update, $context);
	echo "\n", var_dump($updated), "<hr>";
}
catch (\Exception $e) {
	echo "<b>", get_class($e), "</b><br />", $e;
}
echo "<hr>";



try {
	echo "<h4>DELETE</h4>";
	$delete = 'DELETE FROM freetags
	WHERE id < :id
	LIMIT 4';

	$context = array(':id' => $insert_id);

	echo $delete;
	$deleted = $adapter->delete($delete, $context);
	echo "\n", var_dump($deleted), "<hr>";
}
catch (\Exception $e) {
	echo "<b>", get_class($e), "</b><br />", $e;
}
echo "<hr>";




endforeach;
?>
</pre>
