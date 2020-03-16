# personal-details-ws

Personal Details Web Services is a example of how to create a simple CRUD with Symfony, connecting with a MySQL image.

## data base setup

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
Password: *******
Database: personal-data
```

Once inside, you msut select SQl command option for run the next script:

```
ALTER USER 'root' IDENTIFIED WITH mysql_native_password BY 'Password01';
```

This script lets a connection to the database from only the local machine.

## Web services setup

Now you must run the next command for create a table called 'person':

```
bin/console doctrine:migrations:migrate
```
