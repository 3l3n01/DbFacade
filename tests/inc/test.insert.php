<?php
namespace DbFacade\Tests;

#require_once '../config.php';

foreach($facades as $index => $facade):

echo "<h4>", get_class($facade), "</h4>\n";

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
