<?php
namespace DbFacade\Tests;

foreach($facades as $index => $facade):

echo "<h3>", get_class($facade), "</h3>\n";


$select = 'SELECT * FROM words WHERE 1 LIMIT 4';

pretty_print('$words = $facade->read( "' . $select . '" );
foreach($words as $one_word) {
    print_r( $one_word );
}');

$words = $facade->read( $select );

echo "<p><b>Return type:</b> <code>", get_class($words), "</code></p>\n";

echo "<pre>";
foreach($words as $one_word) { print_r( $one_word ); }
echo "</pre>";


endforeach;
