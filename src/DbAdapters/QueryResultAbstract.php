<?php
namespace DbAdapters;

use \DbAdapters\QueryResultInterface;


/**
 * Abstract query result wrapper, derived from SplQueue.
 * The constructor should take whatever the database query returns.
 *
 * Since result record sets usually are used exactly one time,
 * this SplQue objects are set to <code>\SplDoublyLinkedList::IT_MODE_DELETE</code>
 * i.e. after using one element it will be deleted.
 *
 * To retrieve a 'persistent' result set, getRows() returns a clone
 * that does not delete elements after access.
 *
 * @see http://www.php.net/manual/en/class.splqueue.php
 * @see http://www.php.net/manual/en/spldoublylinkedlist.setiteratormode.php
 *
 * @author Carsten Witt <carsten.witt@gmail.com>
 */
abstract class QueryResultAbstract extends \SplQueue
implements QueryResultInterface, \Countable
{

/**
 * @var mixed Database driver query result
 */
    public $result;



/**
 * Accepts the database drivers last query result
 * and configures the SqlQueue as follows:
 *
 * 1. Fill SqlQueue with result rows
 * 2. Switch iterator mode to \SplDoublyLinkedList::IT_MODE_DELETE.
 *
 * @param mixed Database query result
 * @uses  setDriverResult()
 * @uses  populate()
 * @uses  \SplQueue::setIteratorMode()
 * @uses  \SplDoublyLinkedList::IT_MODE_DELETE
 */
    public function __construct($result) {
        $this->setDriverResult( $result );
        $this->populate( $result );
        $this->setIteratorMode(\SplDoublyLinkedList::IT_MODE_DELETE);
    }





/**
 * Delegates every call to non-existent methods to the database result.
 */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->result, $method), $arguments);
    }


/**
 * Interpretes access to unknown members as fields of the the current result row
 *
 * @uses  field()
 */
    public function __get($field)
    {
        return $this->field($field);
    }




//  =======  Implement Interface QueryResultInterface  ===========


/**
 * Shortcut: returns the field value of the current record, if one exists.
 * Otherwise, returns <tt>null</tt>.
 *
 * This shortcut method prevents things like:
 *
 *      $result = $database->query($sql, array(':named' => $value ));
 *      if ($result->count()) {
 *         $id = $result->current()->id
 *      } else {
 *         $id = null;
 *      }
 *
 * @param  string $field Field name
 * @return mixed
 */
    public function field($field) {
        return ($this->count()
        and is_object($current = $this->current()))
        ? $current->$field : null;
    }


/**
 * Returns a cloned QueryResultInterface instance with all records.
 * @return QueryResultAbstract
 */
    public function getRows() {
        $iterator_mode_backup = $this->getIteratorMode();
        $this->setIteratorMode(\SplDoublyLinkedList::IT_MODE_KEEP);

        $result = clone $this;
        $this->setIteratorMode($iterator_mode_backup);
        return $result;
    }


/**
 * Returns the original query result from the database connection used.
 *
 * @return mixed
 * @uses   $result
 */
    public function getDriverResult()
    {
        return $this->result;
    }


/**
 * Stores the original query result from the database connection used.
 *
 * @param  mixed $result
 * @return object Fluent Interface
 * @uses   $result
 */
    public function setDriverResult( $result )
    {
        $this->result = $result;
        return $this;
    }


//  =========  Helpers  =======================


/**
 * @param mixed   $result Anything that can be foreached.
 * @return object Fluent Interfaces.
 */
    protected function populate($result) {
        foreach($result as $record) {
            $this->push( (object) $record);
        }
        $this->rewind();
        return $this;
    }


}
