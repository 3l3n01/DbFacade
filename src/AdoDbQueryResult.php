<?php
namespace NewFreetag\Databases;

use \NewFreetag\Databases\QueryResultInterface;
use \NewFreetag\Databases\QueryResultAbstract;

use \InvalidArgumentException;



/**
 * ADOdb query result wrapper for ADORecordSet objects.
 *
 * @author Carsten Witt <carsten.witt@gmail.com>
 */
class AdoDbQueryResult extends QueryResultAbstract
implements QueryResultInterface
{



/**
 * @param  ADORecordSet|ADORecordSet_empty $ado_rs
 * @uses   QueryResultAbstract::__construct()
 * @throws InvalidArgumentException
 */
    public function __construct($ado_rs)
    {
        if ($ado_rs instanceOf \ADORecordSet
        or  $ado_rs instanceOf \ADORecordSet_empty) {
            parent::__construct($ado_rs);
        }
        else {
            throw new InvalidArgumentException(
                "ADORecordSet or ADORecordSet_empty expected.");
        }
    }


//  =======  Implement interface QueryResultInterface  ===========




/**
 * Returns the number of affected rows.
 *
 * @return int
 * @uses   $result
 * @uses   ADORecordSet::RecordCount()
 * @uses   ADOConnection::$dataProvider()
 * @uses   ADOConnection::Affected_Rows()
 */
    public function affectedRows() {
        return $this->result->dataProvider == "empty"
        ?  : $this->result->connection->Affected_Rows();
    }



}
