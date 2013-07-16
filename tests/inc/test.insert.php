<?php
namespace DbFacade\Tests;

foreach($facades as $index => $facade):

echo "<h3>", get_class($facade), "</h3>\n";

$max = 20;
$insert = 'INSERT INTO words ( word ) VALUES ( :word )';

echo "Running ", $max, " &times ";
pretty_print( $insert );

echo "<pre>";
for ($i = 0; $i < $max; $i++):
    $insert_id = $facade->create( $insert, array(
        ':word' => "Hallo"
    ));
    echo $insert_id, " ";
endfor;
echo "</pre>";




endforeach;
