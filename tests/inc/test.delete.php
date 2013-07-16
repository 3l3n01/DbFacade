<?php
namespace DbFacade\Tests;

#require_once '../config.php';

foreach($facades as $index => $facade):

echo "<h4>", get_class($facade), "</h4>\n";

$delete = 'DELETE FROM words WHERE id > :threshold
LIMIT 7';

pretty_print('$gone = $facade->delete( "'.$delete.'", array(
    ":threshold" => 10
));
var_dump( $gone );

// should print "int 7"
');


$gone = $facade->delete( $delete, array(
    ':threshold' => 10
));

echo "<pre>";
print_r($gone);
echo "</pre>";



endforeach;
