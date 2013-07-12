<?php
namespace NewFreetag\Databases;


/**
 * Methods the Database wrapper instances must provide
 */
interface DatabaseAdapterInterface
{


/**
 * @param  string $str
 * @return string
 */
    public function quote( $str );



/**
 * Method for SELECT statements
 *
 * @param  string $str
 * @return QueryResultInterface
 */
    public function query( $str );



/**
 * Method for INSERT, UPDATE and DELETE statements
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


}
