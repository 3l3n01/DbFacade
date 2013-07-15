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
 * Accepts a PDOStatement instance.
 *
 * @param  \PDOStatement $pdo_rs
 * @uses   QueryResultAbstract::__construct()
 * @throws \InvalidArgumentException
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


//  =======  Additional stuff  ===========


/**
 * Returns the number of affected rows.
 *
 * This method is mainly needed by PdoAdapter::affectedRows()
 * since PDO itself doen not provide a method to return
 * the number of affected rows.
 *
 * @return int
 * @uses   getDriverResult()
 * @uses   PDOStatement::rowCount()
 */
    public function affectedRows() {
        return $this->getDriverResult()->rowCount();
    }


}
