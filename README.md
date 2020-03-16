# personal-details-ws

Personal Details Web Services is a example of how to create a simple CRUD with Symfony, connecting with a MySQL image.

## Project setup

Install docker image with mysql database, this database contains a instance call mysql.development, and a database called personal-data
```
docker-compose up
```

After this is up (it may take a wail if you don't have mysql 5), you can check if the database is up on you browser with the address

```
localhost:8090
```

Now you must run the next command for populate a table called person:

```
bin/console doctrine:migrations:migrate
```
