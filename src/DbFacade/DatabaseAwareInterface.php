<?php
namespace DbFacade;


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
 * @return DatabaseFacadeInterface
 * @throws RuntimeException
 */
    public function getDatabase();


}

