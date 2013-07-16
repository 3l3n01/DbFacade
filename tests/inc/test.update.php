<?php
namespace DbFacade\Tests;

foreach($facades as $index => $facade):

echo "<h3>", get_class($facade), "</h3>\n";

$update = 'UPDATE words SET random = RAND() WHERE id BETWEEN 3 and 7';

pretty_print('$updated = $facade->update( "'.$update.'" );
var_dump( $updated );

// should print "int 5"
');

$updated = $facade->update( $update );
echo pre_dump($updated);





endforeach;
