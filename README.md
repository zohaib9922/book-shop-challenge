# Code Challenge

Imagine your friend - the owner of a small book shop - asks you for a simple representation of his latest sales.
He provides you a simple plain json export file.

**What do you need to do?**

- Design a database scheme for optimized storage
- Read the json data and save it to the database using php
- Create a simple page with filters for customer, product and price
- Output the filtered results in a table below the filters
- Add a last row for the total price of all filtered entries
  
**Additional information:**

The shop system changed the timezone of the sales date.
Prior to version 1.0.17+60 it was Europe/Berlin.
Afterwards it is UTC. Please provide a tested class for the version comparison.
Viewing and Filtering Data

**Environment:**

- Backend: PHP
-	Database: MySQL
-	Frontend: HTML, CSS, Twig (for templating)

## How to run

- After cloning project
- Run `composer install`
- Create a database and change in `config.php`
- Run migrations using `http://localhost/book-shop-challenge/migrate/up`
- Run project `http://localhost/book-shop-challenge`

**File Structure**

- app/Controllers: Contains the controller files.
- app/Models: Contains the model files.
-	app/Helpers: Contains helper classes like Database and Request.
-	app/database/migrations: Contains files for migrating tables.
-	views: Contains the Twig templates for the front end.
-	public: Contains public assets.
