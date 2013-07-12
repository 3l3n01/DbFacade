<?php
namespace tomkyle\DbAdapters;

use \tomkyle\DbAdapters\QueryResultInterface;



/**
 * Methods to provide simplified access to the results of DB queries.
 *
 * @author Carsten Witt <carsten.witt@gmail.com>
 */
interface QueryResultInterface
{
/**
 * Returns the field value of the current record, if one exists.
 * This shortcut method helps to check a single field of a SELECT
 * that targets exactly one record, such as <tt>SELECT COUNT(*) AS count...</tt>
 *
 * @param  string $field Field name
 * @return mixed
 */
    public function field( $field );


/**
 * Returns a QueryResultInterface instance with all records.
 *
 * @return QueryResultInterface
 */
    public function getRows();


/**
 * Returns the number of affected rows
 * @return int
 */
    public function affectedRows();
}
