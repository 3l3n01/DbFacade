<?php
namespace DbAdapters;


/**
 * Methods the Database wrapper instances must provide
 */
interface DatabaseAdapterInterface
{


//  ======  CRUD  =======================


/**
 * Returns the last insert ID
 * @return int
 */
    public function create();


/**
 * Returns the SELECT query result
 * as concretion of QueryResultAbstract
 *
 * @return QueryResultAbstract
 */
    public function read();


/**
 * Returns the number of affected rows.
 * @return int
 */
    public function update();


/**
 * Returns the number of affected rows.
 * @return int
 */
    public function delete();


//  ======  Typical DB methods  =========


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
 * Returns the number of affected rows.
 * @return int
 */
    public function affectedRows();


/**
 * Returns the ID of the last inserted object.
 * @return int
 */
    public function getInsertId();




}
