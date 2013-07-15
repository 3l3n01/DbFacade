<?php
namespace DbAdapters;

use \DbAdapters\DatabaseAdapterInterface;
use \DbAdapters\DatabaseAdapterAbstract;
use \DbAdapters\PdoQueryResult;

use \Exception;
use \PDO;


/**
 * PDO wrapper
 *
 * @author Carsten Witt <carsten.witt@germania-kg.de>
 */
class PdoAdapter extends DatabaseAdapterAbstract
implements DatabaseAdapterInterface
{


/**
 * Stores the original PDO fetch mode to make it restorable
 * after using in this context.
 *
 * The restauration will not be done automatically;
 * simply call restoreFetchMode() whenever you need it.
 */
    public $fetch_mode_backup = 0;


/**
 * @param \PDO $pdo PDO Connection
 * @uses  backupFetchMode()
 */
    public function __construct( \PDO $pdo )
    {
        $this->connection = $pdo;
        $this->backupFetchMode();
    }


//  ======  CRUD  =======================





//  ========  Implement Interface DatabaseConnectionInterface  =======


/**
 * Escapes and quotes the given string for using in the database.
 * Should not be needed when using prepared statements.
 *
 * @param  string $str
 * @return string
 * @uses   $connection
 * @uses   PDO::quote()
 */
    public function quote( $str )
    {
        return $this->connection->quote($str);
    }


/**
 * Executes the given SQL string after preparing it.
 * For preparing, pass an associative array with named parameters as keys and values.
 *
 * @param  string $str
 * @param  array  $context The named parameters and values, default empty
 * @return PdoQueryResult
 *
 * @uses   $connection
 * @uses   setResult()
 * @uses   getResult()
 * @uses   prepare()
 * @uses   getErrorMsg()
 * @uses   PDOStatement::execute()
 *
 * @throws Exception
 */
    public function execute( $sql, $context = array() )
    {
        $statement = $this->prepare($sql);
        if ($result = $statement->execute($context)) {
            return $this->setResult(
                new PdoQueryResult($statement))->getResult();
        }
        throw new Exception("Syntax Error: $sql, Error: " . $this->getErrorMsg());
    }


/**
 * Returns the number of affected rows.
 * @return int
 * @uses   getResult()
 * @use    PdoQueryResult::affectedRows()
 */
    public function affectedRows() {
        return $this->getResult()->affectedRows();
    }


/**
 * Returns the ID of the last inserted object.
 * @return int
 * @uses   $connection
 * @uses   \PDO::lastInsertId()
 */
    public function getInsertId()
    {
        return $this->connection->lastInsertId();
    }


//  ==============  Helpers  =======================


/**
 * Returns PDOs' last error message.
 *
 * @return string
 * @uses  $connection
 * @uses  PDO::errorInfo()
 */
    public function getErrorMsg( )
    {
        $ei = $this->connection->errorInfo();
        return print_r($ei, "noecho");
    }


/**
 * Since db result are SdtClass objects, we need a fetch mode that retrieves objects
 * rather than associative or numeric arrays. This method stores the  "fetch mode"
 * for later restoration.
 *
 * The restauration will not be done automatically;
 * simply call restoreFetchMode() whenever you need it.
 *
 * @return object Fluent Interface
 * @uses   $connection
 * @uses   ADO::getAttribute()
 */
    public function backupFetchMode() {
        $this->fetch_mode_backup = $this->connection->getAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE);
        $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        return $this;
    }


/**
 * Applies the previously backupped fetch mode.
 *
 * @return object Fluent Interface
 * @uses   $connection
 * @uses   $fetch_mode_backup
 * @uses   ADO::setAttribute()
 */
    public function restoreFetchMode() {
        $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, $this->fetch_mode_backup);
        return $this;
    }


//  ===========  Additional Stuff  ===============


/**
 * @return PDOStatement
 *
 * @uses   $connection
 * @uses   PDO::prepare()
 * @uses   PDOStatement::bindValue()
 */
    public function prepare( $str, $context = array() )
    {
        $statement = $this->connection->prepare($str);

        foreach($context as $param => $value) {
            $statement->bindValue($param, $value);
        }

        return $statement;
    }


}
