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
 * Stores the database connection that enables you speaking to a database
 * @var mixed
 */
    protected $connection;

/**
 * Stores the last query result
 * @var mixed
 */
    protected $result;





/**
 * factory
 *
 * Returns a concrete DatabaseAdapterAbstract instance for the given database connection.
 * Currently, the following databases are supported:
 *
 * - PDO (PDO instance)
 * - ADODB (ADOConnection instance)
 *
 * @param  mixed $db Database driver
 * @return DatabaseAdapterInterface
 *
 * @uses   AdoDbAdapter
 * @uses   PdoAdapter
 * @uses   \ADOConnection
 * @uses   \PDO
 * @uses   DatabaseAdapterInterface
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


//  ============  Implemenet Interface DatabaseAdapterInterface  =============


/**
 * @return int Last insert ID
 */
    public function create($sql, $context = array())
    {
        $this->execute($sql, $context);
        return $this->getInsertId();
    }

/**
 * Returns the SELECT query result
 * as concretion of QueryResultAbstract
 *
 * @return QueryResultAbstract
 */
    public function read($sql, $context = array())
    {
        return $this->query($sql, $context);
    }


/**
 * Returns the number of affected rows.
 * @return int
 */
    public function update($sql, $context = array())
    {
        $this->execute($sql, $context);
        return $this->affectedRows();
    }


/**
 * Returns the number of affected rows.
 * @return int
 */
    public function delete($sql, $context = array())
    {
        $this->execute($sql, $context);
        return $this->affectedRows();
    }


//  ======  Typical DB methods  =========


/**
 * Escapes and quotes the given string for using in the database.
 * Should not be needed when using prepared statements.
 *
 * @param  string $str
 * @return string
 */
    abstract public function quote( $str );


/**
 * Executes the given SQL string.
 *
 * @param  string $str
 * @return QueryResultAbstract
 */
    abstract public function execute( $str );


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




//  ============  Helpers  ========================



/**
 * Returns the last error message.
 * @return string
 */
    abstract public function getErrorMsg( );


/**
 * Creates a backup from the current driver configuration.
 * @return object Fluent Interface
 */
    abstract public function backupConfiguration();


/**
 * Applies the former driver configuration from the backup taken before.
 * @return object Fluent Interface
 */
    abstract public function restoreConfiguration();



//  ===========  Additional Stuff  ===============


/**
 * Returns the last query result.
 *
 * @uses   $result
 * @return QueryResultAbstract
 */
    public function getResult()
    {
        return $this->result;
    }


/**
 * Stores the last query result.
 *
 * @param  mixed $result
 * @return object Fluent Interface
 * @uses   $result
 */
    public function setResult( $result )
    {
        $this->result = $result;
        return $this;
    }


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
