<?php
namespace NewFreetag\Databases;

use \NewFreetag\Databases\DatabaseAdapterInterface;


/**
 * @author Carsten Witt <carsten.witt@germania-kg.de>
 */
interface DatabaseAwareInterface
{


/**
 * Pass the database connection your application talks with.
 *
 * @return object Fluent Interface
 * @throws UnexpectedValueException
 */
    public function setDatabase( $db );


/**
 * @return DatabaseAdapterInterface
 * @throws RuntimeException
 */
    public function getDatabase();


}

