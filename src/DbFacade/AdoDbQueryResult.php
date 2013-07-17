<?php
namespace DbFacade;

use \DbFacade\QueryResultInterface;
use \DbFacade\QueryResultAbstract;

use \InvalidArgumentException;


/**
 * ADOdb result wrapper for ADORecordSet objects.
 *
 * @package QueryResults
 * @author  Carsten Witt <carsten.witt@gmail.com>
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
