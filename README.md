#tomkyle/DbAdapters
DbAdapters gives you what you are interested in most when talking to databases:

- When you SELECT something, you are interested in the records.
– After INSERTING, the new ID is the most important.
- When UPDATEing or DELETEing, its the number of affected rows that you are after.

DbAdapters aims a simple method API for creating, reading, updating and deleting. Each CRUD method returns the most important thing.

##Why?
Recently I needed to modernize a legacy library working with PHP's old school mysql-*-functions, wrapped by ADOdb. I found it annoying that PDO, mysqli and ADOdb have their own API.

##How?
…Sry, not everything at once, folks.
