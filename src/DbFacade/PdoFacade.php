<?php
namespace DbFacade;

use \DbFacade\DatabaseFacadeInterface;
use \DbFacade\DatabaseFacadeAbstract;
use \DbFacade\PdoQueryResult;

use \Exception;
use \PDO;


/**
 * PDO facade
 *
 * @package Facades
 * @author  Carsten Witt <carsten.witt@gmail.com>
 */
class PdoFacade extends DatabaseFacadeAbstract
implements DatabaseFacadeInterface
{



/**
 * Stores the original configuration as far as it is changed
 * by the adapter concretion.
 *
 * The restauration will not be done automatically;
 * simply call restoreAttributes() whenever you need it.
 */
    public $pdo_configuration_backup = array();


/**
 * Accepts a PDO instance.
 *
 * Additionally, takes a backup from its current configuration.
 *
 * @param \PDO $pdo PDO Connection
 * @uses  backupConfiguration()
 */
    public function __construct( \PDO $pdo )
    {
        $this->connection = $pdo;
        $this->backupConfiguration();
    }


//  ======  Typical DB methods  =========


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
 *
 * @return int
 * @uses   getResult()
 * @use    PdoQueryResult::affectedRows()
 */
    public function affectedRows() {
        return $this->getResult()->affectedRows();
    }


/**
 * Returns the ID of the last inserted object.
 *
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
 * Creates a backup from the current PDO configuration.
 *
 * The restauration will not be done automatically;
 * simply call restoreAttributes() whenever you need it.
 *
 * @return object Fluent Interface
 * @uses   $connection
 * @uses   $pdo_configuration_backup
 * @uses   PDO::getAttribute()
 * @uses   PDO::setAttribute()
 */
    public function backupConfiguration() {
        $this->pdo_configuration_backup = array(
            \PDO::ATTR_DEFAULT_FETCH_MODE => $this->connection->getAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE),
            \PDO::ATTR_ERRMODE            => $this->connection->getAttribute(\PDO::ATTR_ERRMODE),
        );

        $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE,            \PDO::ERRMODE_EXCEPTION);
        return $this;
    }


/**
 * Applies the former PDO configuration from the backup taken before.
 *
 * @return object Fluent Interface
 * @uses   $connection
 * @uses   $pdo_configuration_backup
 * @uses   PDO::setAttribute()
 */
    public function restoreConfiguration() {
        foreach( $this->pdo_configuration_backup as $conf => $value) {
            $this->connection->setAttribute($conf, $value);
        }
        return $this;
    }



/**
 * Prepares the given SQL string and returns a prepared stamement
 * (instance of PDOStatement).
 *
 * Optionally, pass an associative array with named paramters as keys and values.
 *
 * @param  string $sql     SQL string, optionally with named parameters
 * @param  array  $context The named parameters and values, default empty
 *
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
