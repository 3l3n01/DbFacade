<?php
namespace DbAdapters;

use \DbAdapters\QueryResultInterface;
use \DbAdapters\QueryResultAbstract;

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
 * Accepts a ADORecordSet or ADORecordSet_empty instance.
 *
 * @param  \ADORecordSet|\ADORecordSet_empty $ado_rs
 * @uses   QueryResultAbstract::__construct()
 * @throws \InvalidArgumentException
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


}
