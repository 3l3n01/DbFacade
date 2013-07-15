<?php
namespace DbAdapters;

use \DbAdapters\DatabaseAdapterInterface;
use \DbAdapters\DatabaseAdapterAbstract;

use \Exception;
use \ADOConnection;

use \DbAdapters\AdoDbQueryResult;


/**
 * ADOdb wrapper
 *
 * @author Carsten Witt <carsten.witt@germania-kg.de>
 */
class AdoDbAdapter extends DatabaseAdapterAbstract
implements DatabaseAdapterInterface
{



/**
 * Stores the original ADOConnection FetchMode to make it restorable
 * after using in this context.
 *
 * The restauration will not be done automatically;
 * simply call restoreFetchMode() whenever you need it.
 */
    public $fetch_mode_backup = 0;


/**
 * Since we'll work with assiciative result sets,
 * the methods creates a backup from the current/previous ADOdb FetchMode.
 * It can be restored with restoreFetchMode().
 *
 * @param \ADOConnection $ado ADODB Connection
 * @uses  storeFetchMode()
 */
    public function __construct( \ADOConnection $ado )
    {
        $this->connection = $ado;
        $this->storeFetchMode();
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
 * @uses   \ADOConnections::qstr()
 */
    public function quote( $str )
    {
        return $this->connection->qstr($str);
    }


/**
 * Executes the given SQL string after preparing it.
 * For preparing, pass an associative array with named parameters as keys and values.
 *
 * @param  string $sql     SQL string, optionally with named parameters
 * @param  array  $context The named parameters and values, default empty
 * @return AdoDbQueryResult
 *
 * @uses   $connection
 * @uses   setResult()
 * @uses   getResult()
 * @uses   prepare()
 * @uses   getErrorMsg()
 * @uses   \ADOConnection::Execute()
 * @uses   AdoDbQueryResult
 *
 * @throws \Exception
 */
    public function execute( $sql, $context = array() )
    {
        $stmt = $this->prepare($sql, $context);
        if ($result = $this->connection->Execute($stmt, $context)) {
            return $this->setResult(
                new AdoDbQueryResult($result))->getResult();
        }
        throw new \Exception("Syntax Error: $sql, Error: " . $this->getErrorMsg());
    }


/**
 * Returns the number of affected rows.
 * @return int
 * @uses   $result
 * @uses   ADOConnection::Affected_Rows()
 */
    public function affectedRows() {
        return $this->connection->Affected_Rows();
    }


/**
 * Returns the ID of the last inserted object.
 * @return int
 * @uses   $connection
 * @uses   ADOConnection::Insert_ID()
 */
    public function getInsertId()
    {
        return $this->connection->Insert_ID();
    }


/**
 * Returns ADOConnections' last error message.
 *
 * @return string
 * @uses  $connection
 * @uses   ADOConnection::ErrorMsg()
 */
    public function getErrorMsg( )
    {
        return $this->connection->ErrorMsg();
    }


/**
 * Since db results are SdtClass objects, we need a fetch mode that retrieves objects
 * rather than associative or numeric arrays. This method stores the  "fetch mode"
 * for later restoration.
 *
 * The restauration will not be done automatically;
 * simply call restoreFetchMode() whenever you need it.
 *
 * @return object Fluent Interface
 * @uses   $connection
 * @uses   $fetch_mode_backup
 * @uses   ADOConnection::$fetchMode
 * @uses   ADOConnection::SetFetchMode()
 */
    public function storeFetchMode() {
        $this->fetch_mode_backup = (int) $this->connection->fetchMode;
        $this->connection->SetFetchMode(\ADODB_FETCH_ASSOC);
        return $this;
    }


/**
 * Applies the previously backupped fetch mode.
 *
 * @return object Fluent Interface
 * @uses   $connection
 * @uses   $fetch_mode_backup
 * @uses   ADOConnection::SetFetchMode()
 */
    public function restoreFetchMode() {
        $this->connection->SetFetchMode($this->fetch_mode_backup);
        return $this;
    }



//  ========  Helpers  =========================




/**
 * Prepares the given SQL string. Pass an associative array with
 * named paramters as keys and values.
 *
 * @param  string $sql     SQL string, optionally with named parameters
 * @param  array  $context The named parameters and values, default empty
 * @return string
 *
 * @uses   $connection
 * @uses   ADOConnection::Param()
 * @uses   ADOConnection::Prepare()
 */
    public function prepare( $sql, $context = array() )
    {
        foreach($context as $param => $value) {
            $sql = str_replace($param, $this->connection->Param(substr($param, 1)), $sql);
        }
        return $this->connection->Prepare($sql);
    }



}
