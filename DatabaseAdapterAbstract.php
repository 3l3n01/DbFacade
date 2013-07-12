<?php
namespace DbAdapters;

use \DbAdapters\DatabaseAdapterInterface;
use \DbAdapters\AdoDbAdapter;
use \DbAdapters\PdoAdapter;

use \UnexpectedValueException;
use \InvalidArgumentException;

/**
 * Abstract database wrapper
 *
 * @author Carsten Witt <carsten.witt@germania-kg.de>
 */
abstract class DatabaseAdapterAbstract
implements DatabaseAdapterInterface
{


/**
 * @var bool
 */
    protected $debug;



/**
 * Returns a concrete DatabaseAdapterInstance instance for the given database connection.
 * Currently, the following databases are supported:
 *
 * - PDO
 * - ADODB
 *
 * @param  mixed $db Database driver
 * @return DatabaseAdapterInterface
 *
 * @uses   AdoDbAdapter
 * @uses   \ADOConnection
 * @uses   PdoAdapter
 * @uses   \PDO
 * @uses   DatabaseAdapterInterface
 * @uses   DatabaseAdapterInterface::debug()
 * @throws InvalidArgumentException
 */
    public static function factory( $database ) {
        if ($database instanceOf DatabaseAdapterInterface) {
            return $database;
        }
        if ($database instanceOf \ADOConnection) {
            return new AdoDbAdapter($database);
        }
        else if ($database instanceOf \PDO) {
            return new PdoAdapter($database);
        }
        throw new InvalidArgumentException("The database connection given ist currently not supported");
    }








/**
 * Stores the database connection that enables you speaking to a database
 * @var mixed
 */
    protected $connection;


/**
 * Stores the last query result
 * @var mixed
 */
    protected $result;



//  ============  Implemenet Interface DatabaseAdapterInterface  =============



/**
 * Escapes and quotes the given string for using in the database.
 * Should not be needed when using prepared statements.
 *
 * @param  string $str
 * @return string
 */
    abstract public function quote( $str );


/**
 * Method for SELECT statements
 *
 * @param  string $str
 * @return QueryResultAbstract
 */
    abstract public function query( $str );



/**
 * Method for INSERT, UPDATE and DELETE statements
 *
 * @param  string $str
 * @return QueryResultAbstract
 */
    abstract public function execute( $str );




/**
 * @uses   $result
 * @return QueryResultAbstract
 */
    public function getResult()
    {
    	return $this->result;
    }



/**
 * Returns the number of affected rows.
 * @return int
 */
    abstract public function affectedRows();



/**
 * Returns the ID of the last inserted object.
 * @return int
 */
    abstract public function getInsertId();




/**
 * Returns the last error message.
 * @return string
 */
    abstract public function getErrorMsg( );




//  ============  Helpers  ========================



/**
 * Return information about the database connection as string.
 *
 *
 * @return string
 * @uses   $connection
 */
    public function info()
    {
        return "<pre>" . print_r($this->connection, "noecho") . "</pre>";
    }


/**
 * Returns or sets the debug state of the database connection
 * (pass bool for setting, or null for getting).
 *
 * If used as setter, the method should return the object itself
 * to make fluent interfaces possible.
 *
 * @param  mixed bool|null
 * @return mixed bool|object Fluent Interface (setter) or debugging state (getter)
 * @uses   $debug
 */
    public function debug( $flag = null )
    {
        if (is_null( $flag )) {
            return $this->debug;
        }
        $this->debug = (bool) $flag;
        return $this;
    }




}
