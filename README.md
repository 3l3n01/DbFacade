#About
DbFacade gives you what you are interested in most when talking to databases:

- When you `SELECT` something, you are interested in the records.
- After `INSERTING`, the new ID is the most important for you.
- When `UPDATE`ing or `DELETE`ing, its the number of affected rows that you are after.

Thus, DbFacade provides a simple method API for simple creating, reading, updating and deleting. It currently supports [PDO](http://php.net/manual/en/book.pdo.php) and [ADOdb](http://phplens.com/adodb/); mysqli and sqlite will be the next steps.

##Why another DBAL?
Recently I needed to modernize a legacy library working with PHP's old school `mysql-*`-functions, wrapped by ADOdb. I found it annoying that DB wrappers and drivers each have their own concepts on how to find the affected rows or retrieve the last insert ID.

##Should I use it?
**DbFacade is for you, when** 
- you write a small standalone app or plugin that should not be determined to a certain DB or ORM.
- you plan to test simple queries against popluar DB dialects  
   (well, at least when DbFacade supports more than one or two of them, one fine day), 
- full-blown DBAL like Doctrine seem too fat for your needs.

**DbFacade is not for you** when your existing application is running well or deploys recent database magic such as PDO, mysqli or [Doctrine DBAL](http://www.doctrine-project.org/projects/dbal.html).

##Please note
- This project is still in progress, so better not use in production environment.
- I am a bloody git newbie. Any hints on how to “git” better will be appreciated :-)

