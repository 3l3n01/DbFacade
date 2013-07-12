<?php
namespace NewFreetag\Databases;

use \NewFreetag\Databases\DatabaseAdapterInterface;
use \NewFreetag\Databases\DatabaseAdapterAbstract;

use \Exception;
use \PDO;
use \NewFreetag\Databases\PdoQueryResult;



/**
 * PDO wrapper
 *
 * @author Carsten Witt <carsten.witt@germania-kg.de>
 */
class PdoAdapter extends DatabaseAdapterAbstract
implements DatabaseAdapterInterface
{




/**
 * @param PDO $pdo PDO Connection
 * @uses  $connection
 */
    public function __construct( \PDO $pdo )
    {
        $this->connection = $pdo;
    }




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
 * Method for SELECT statements
 * Executes the given SQL string after preparing it.
 * For preparing, pass an associative array with named paramters as keys and values.
 *
 * @param  string $sql     SQL string, optionally with named parameters
 * @param  array  $context The named parameters and values, default empty
 * @return PdoQueryResult
 *
 * @uses   $connection
 * @uses   $this
 * @uses   PDOStatement::execute()
 * @uses   PdoQueryResult
 */
    public function query( $sql, $context = array() )
    {
        $statement = $this->prepare($sql, $context);
        if ($result = $statement->execute($context)) {
            $this->result = new PdoQueryResult($statement);
            return $this->result;
        }
        throw new Exception("Syntax Error: $sql, Error: " . $this->getErrorMsg());
    }




/**
 * Method for INSERT, UPDATE and DELETE statements
 * Executes the given SQL string after preparing it.
 * For preparing, pass an associative array with named parameters as keys and values.
 *
 * @param  string $str
 * @param  array  $context The named parameters and values, default empty
 * @return PdoQueryResult
 *
 * @uses   $connection
 * @uses   $result
 * @uses   prepare()
 * @uses   getErrorMsg()
 * @uses   PDOStatement::execute()
 *
 * @throws Exception
 */
    public function execute( $sql, $context = array() )
    {
        $statement = $this->prepare($sql, $context);

        if ($result = $statement->execute($context)) {
            $this->result = new PdoQueryResult($statement);
            return $this->result;
        }
        throw new Exception("Syntax Error: $sql, Error: " . $this->getErrorMsg());
    }





/**
 * Returns the number of affected rows.
 * @return int
 * @uses   $result
 */
    public function affectedRows() {
        return $this->result->rowCount();
    }




/**
 * Returns the ID of the last inserted object.
 * @return int
 * @uses   $connection
 * @uses   PDO::lastInsertId()
 */
    public function getInsertId()
    {
        return $this->connection->lastInsertId();
    }





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






}
