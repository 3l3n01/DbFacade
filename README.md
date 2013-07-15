#tomkyle/DbAdapters
DbAdapters gives you what you are interested in most when talking to databases:

- When you `SELECT` something, you are interested in the records.
- After `INSERTING`, the new ID is the most important for you.
- When `UPDATE`ing or `DELETE`ing, its the number of affected rows that you are after.

DbAdapters provides a simple method API for simple creating, reading, updating and deleting.

###Currently supported:
- PDO
- ADOdb

###Coming soon
- mysqll
- sqlite

##Why another DBAL?
Recently I needed to modernize a legacy library working with PHP's old school `mysql-*`-functions, wrapped by [ADOdb](http://phplens.com/adodb/). First, I found it annoying that DB wrappers and drivers like [PDO](http://php.net/manual/en/book.pdo.php), mysqli and ADOdb each have their own concepts on how to find the affected rows or retrieve the last insert ID.  

##Should I use it?
DbAdapters is for you when you plan to test simple queries against popluar DB dialects (at least when DbAdapters supports more than one or two of them, one fine day), and full-blown DBAL like Doctrine seem too fat for your needs.

DbAdapters is not for you when your application is running well or deploys recent database magic such as PDO, mysqli or [Doctrine DBAL](http://www.doctrine-project.org/projects/dbal.html)
