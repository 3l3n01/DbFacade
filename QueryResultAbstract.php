<?php
namespace NewFreetag\Databases;

use \NewFreetag\Databases\QueryResultInterface;


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
 * @var mixed Database query result
 */
    public $result;



/**
 * @param mixed Database query result
 * @uses  $result
 */
    public function __construct($result) {
        $this->result = $result;
        $this->populate($result);
        $this->setIteratorMode(\SplDoublyLinkedList::IT_MODE_DELETE);
        #$this->setIteratorMode(\SplDoublyLinkedList::IT_MODE_KEEP);
    }






/**
 * Delegates every call to non-existent methods to the database result.
 */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->result, $method), $arguments);
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
        ? $current()->$field : null;
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
 * Returns the number of affected rows.
 * @return int
 */
    abstract public function affectedRows();



//  =======  Helpers  ===========

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
