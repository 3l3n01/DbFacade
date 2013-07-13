<?php
namespace DbAdapters;

use \DbAdapters\QueryResultInterface;
use \DbAdapters\QueryResultAbstract;

use \InvalidArgumentException;


/**
 * PDO query result wrapper for PDOStatement objects.
 *
 * @author Carsten Witt <carsten.witt@gmail.com>
 */
class PdoQueryResult extends QueryResultAbstract
implements QueryResultInterface
{


/**
 * @param \PDOStatement $pdo_rs
 * @uses  QueryResultAbstract::__construct()
 * @throws InvalidArgumentException
 */
    public function __construct($pdo_rs)
    {
        if ($pdo_rs instanceOf \PDOStatement) {
            parent::__construct($pdo_rs);
        }
        else {
            throw new InvalidArgumentException("PDOStatement expected.");
        }
    }



//  =======  Implement interface QueryResultInterface  ===========



/**
 * Returns the number of affected rows.
 *
 * @return int
 * @uses   $result
 * @uses   PDOStatement::rowCount()
 */
    public function affectedRows() {
        return $this->result->rowCount();
    }




}
