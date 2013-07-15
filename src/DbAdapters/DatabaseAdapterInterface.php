<?php
namespace DbAdapters;


/**
 * Methods the Database wrapper instances must provide
 */
interface DatabaseAdapterInterface
{


/**
 * Escapes and quotes the given string for using in the database.
 * Should not be needed when using prepared statements.
 *
 * @param  string $str
 * @return string
 */
    public function quote( $str );




/**
 * Executes the given SQL string.
 *
 * @param  string $str
 * @return QueryResultInterface
 */
    public function execute( $str );


/**
 * @return QueryResultInterface
 */
    public function getResult();



/**
 * Returns the number of affected rows.
 * @return int
 */
    public function affectedRows();



/**
 * Returns the ID of the last inserted object.
 * @return int
 */
    public function getInsertId();



/**
 * Returns the last error message.
 * @return string
 */
    public function getErrorMsg( );


/**
 * Stores the current fetch mode.
 * @return object Fluent Interface
 */
    public function storeFetchMode();


/**
 * Restores the current fetch mode.
 * @return object Fluent Interface
 */
    public function restoreFetchMode();

}
