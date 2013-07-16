<?php
namespace DbFacade\Tests;
require_once 'config.php';
require_once 'inc/html.intro.php';
?>
<div class="page-header">
  <h1>DbFacade <small>gives you what you are really interested in</small></h1>
</div>

<div class="lead">
    <p>When talking to databases, this is what we are after:</p>
    <ul>
    <li>When you <code>SELECT</code> something, you are interested in records.</li>
    <li>After <code>INSERTING</code>, it's the new ID you are after,</li>
    <li>when <code>UPDATE</code>ing or <code>DELETE</code>ing, the number of affected rows.</li>
    </ul>

    <p>DbFacade provides a simple method API.</p>
</div>


<ul class="nav nav-tabs">
    <li class="active"><a href="#overview" data-toggle="tab">Overview</a></li>
    <li><a href="#instantiate" data-toggle="tab">Instantiation</a></li>
    <li><a href="#select" data-toggle="tab">SELECT</a></li>
    <li><a href="#insert" data-toggle="tab">INSERT</a></li>
    <li><a href="#update" data-toggle="tab">UPDATE</a></li>
    <li><a href="#delete" data-toggle="tab">DELETE</a></li>
</ul>


<div class="tab-content">



<div class="tab-pane active" id="overview">
<?php require_once 'inc/inc.overview.php'; ?>
</div> <!-- /.tab-pane -->

<div class="tab-pane" id="instantiate">
<?php require_once 'inc/inc.instantiate.php'; ?>
</div> <!-- /.tab-pane -->



<div class="tab-pane" id="select">

<p class="lead">The <code>read</code> method returns a concretion of <code>\DbFacade\QueryResultAbstract</code>
which itself is derived from <code>\SplQueue</code><br />
The result object consists of <code>StdClass</code> objects.</p>

<?php
require_once 'inc/test.select.php';
?>
</div>


<div class="tab-pane" id="insert">
<p class="lead">The <code>create</code> method returns the last inserted ID as <code>integer</code> value.</p>

<?php
require_once 'inc/test.insert.php';
?>
</div>


<div class="tab-pane" id="update">
<p class="lead">The <code>update</code> method returns the number of affected rows as <code>integer</code> value.</p>
<?php
require_once 'inc/test.update.php';
?>
</div>


<div class="tab-pane" id="delete">
<p class="lead">The <code>delete</code> method returns the number of affected rows as <code>integer</code> value.</p>
<?php
require_once 'inc/test.delete.php';
?>
</div>

<?php

/*// ================= Catching testing exceptions  ====================
}
catch (\Exception $e) {
    echo '<div class="exception"><b>', get_class($e), ": </b>",
    $e->getMessage(),       "<br />",
    $e->getTraceAsString(),
    "</div><!-- /.exception -->\n";
}
*/
?>

</div> <!-- /.tab-content -->

<?php
require_once 'inc/html.outro.php';
