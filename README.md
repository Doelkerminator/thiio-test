# Thiio skill assessment 
This is the Thiio skill assessmente asigned to me, which consists of a user management web application.

## Setting up the environment!

> [!IMPORTANT] 
> This project was made on a linux environment. Please run in Ubuntu or alikes

| This app requires |
|:------------------|
 - PHP  ^8.1.2      
 - Composer 2
 - MySQL ^8.0.36
 - Node ^20.12.0

After you cloned the repository with

```
git clone https://github.com/Doelkerminator/thiio-test
```

run the SQL script `db-setup.sql` with mysql CLI.

```bash
 mysql> source ./db-setup.sql
```

Then, access to the ``` user-mng-back ``` folder and run the following commands:

```
composer update
php artisan migrate
php artisan db:seed
```

Finally, you must run this command inside `user-mng-front` directory:

```
npm install
```

Once you've done all this, to set the application going run this command inside `user-mng-back` :
````
php artisan serve
````
And this one inside `user-mng-front` :
````
npm run dev
````
> [!TIP] ALL DONE
> And that's it, now you can make use of the User Manager Web Application!

## How to run tests

> [!IMPORTANT]
> Many of these tests are made under the assumption there is a valid JWT in the Test file. Which means that if you don't get such JWT running the Login endpoint in a API plattform such as Postman, they **will** fail. Nonetheless, be sure that the application works without issues.

To run the API's tests, just run the following command inside `user-mng-back` :
````
php artisan test
````

## How to **actually** test the app

Having both `user-mng-back` and `user-mng-front` projects running, access the app in your preferred browser (such as Chrome) via the url: http://127.0.0.1:3000.


And at last, but not least:

### THANKS!