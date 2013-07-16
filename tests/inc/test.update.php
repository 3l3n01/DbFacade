<?php
namespace DbFacade\Tests;

#require_once '../config.php';

foreach($facades as $index => $facade):

echo "<h4>", get_class($facade), "</h4>\n";

$update = 'UPDATE words SET random = RAND() WHERE id BETWEEN 3 and 7';

pretty_print('$updated = $facade->update( "'.$update.'" );
var_dump( $updated );

// should print "int 5"
');

$updated = $facade->update( $update );

echo "<pre>";
print_r($updated);
echo "</pre>";






endforeach;
