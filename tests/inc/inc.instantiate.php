<?php
namespace DbFacade\Tests;
?>


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

