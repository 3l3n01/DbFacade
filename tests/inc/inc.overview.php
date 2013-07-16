<?php
namespace DbFacade\Tests;
?>

<p class="lead">DbFacade provides a CRUD-like method API.
Its methods are <code>create</code>, <code>read</code>, <code>udpate</code> and <code>delete</code>.<br/>
Simply pass an SQL string, optionally with named parameters and an context array that holds the parameter values.</p>


<h5>CREATE / INSERT</h5>
<pre class="prettyprint linenums">
// returns last insert ID
$new_id = $facade->create( 'INSERT INTO words (word) VALUES (:new)', array(
    ':new' => "Foo"
));
</pre>


<h5>READ / SELECT</h5>
<pre class="prettyprint linenums">
// returns concretion of \DbFacade\QueryResultAbstract
$records = $facade->read( 'SELECT * FROM words WHERE id = :what', array(
    ':what' => $search
));
</pre>


<h5>UDPATE</h5>
<pre class="prettyprint linenums">
// returns number of affected rows
$affected = $facade->update( 'UPDATE words SET word = :value WHERE 1', array(
    ':value' => "Bar"
));
</pre>


<h5>DELETE</h5>
<pre class="prettyprint linenums">
// returns number of affected rows
$gone = $facade->delete( 'DELETE FROM words WHERE id = :vanish', array(
    ':vanish' => $id
));
</pre>
