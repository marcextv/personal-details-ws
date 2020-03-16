# personal-details-ws

Personal Details Web Services is a example of how to create a simple CRUD with Symfony, connecting with a MySQL image.

# What you need


You must have:

- PHP 7.3
- Symfony 4.12
- Docker 19
- Docker compose 1.23.2


## Data base setup

Install docker image with mysql database, this database contains a instance call mysql.development, and a database called personal-data:
```
docker-compose up
```

After this is up (it may take a wail if you don't have mysql 5), you can check if the database is up on you browser with the address:

```
localhost:8090
```

The file docker-compose.yml contains the password for acces to the database as root. The parameters for access are:

```
Server: mysql
Username: root
Password: <Password value>
Database: personal-data
```

Once inside, you msut select SQl command option for run the next script:

```
ALTER USER 'root' IDENTIFIED WITH mysql_native_password BY '<Password value>';
```

This script lets a connection to the database from only the local machine.

## Web services setup

Now you must run the next command for create a table called 'person' in another terminal:

```
bin/console doctrine:migrations:migrate
```

You could populate the table with the next command:

```
bin/console doctrine:fixtures:load
```
This would insert some data to table Person, purging any other value inside that table.

Finally, you can start the server with:

```
bin/console server:run
```

You can access the web services with the address:

```
http://localhost:8000/
```

## Included Services

Creates a new person.
```
http://localhost:8000/person
POST
```
```
//JSON Example
{
  "name":"test",
  "lastName":"tester",
  "email":"test@email.com",
  "ci":"1234567890"
}
```

Returns all person in JSON format.
```
http://localhost:8000/person
GET
```

Returns a person for id.
```
http://localhost:8000/person/[id]
GET
```

Updates a person data based on id.
```
http://localhost:8000/person/[id]
PUT
```
```
//JSON Example
{
  "name":"test12",
  "lastName":"tester12",
  "email":"test12@email.com",
  "ci":"1234567888"
}
```

Deletes a person by id.
```
http://localhost:8000/person/[id]
DELETE
```
