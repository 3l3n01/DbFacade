<?php
namespace DbFacade\Tests;

foreach($facades as $index => $facade):

echo "<h4>", get_class($facade), "</h4>\n";


$select = 'SELECT * FROM words WHERE 1 LIMIT 4';

pretty_print('$words = $facade->read( "' . $select . '" );

$results[0] = $words->id;
$results[1] = $words->field("word");

$words->next();
$results[2] = $words->current();
$results[3] = $words->id;
$results[4] = $words->field("word");

print_r($results);
');

$words = $facade->read( $select );

$results[0] = $words->id;
$results[1] = $words->field("word");

$words->next();
$results[2] = $words->current();
$results[3] = $words->id;
$results[4] = $words->field("word");

echo "<pre>";
print_r($results);
echo "</pre>";


endforeach;
