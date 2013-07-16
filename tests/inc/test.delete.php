<?php
namespace DbFacade\Tests;

foreach($facades as $index => $facade):

echo "<h4>", get_class($facade), "</h4>\n";

$delete = 'DELETE FROM words WHERE id > (:newest - 7)';

pretty_print('$gone = $facade->delete( "'.$delete.'", array(
    ":newest" => $insert_id
));
var_dump( $gone );

// should print "int 7"
');


$gone = $facade->delete( $delete, array(
    ':newest' => $insert_id
) );
echo pre_dump($gone);




endforeach;
