<h1 align="center"> Product Catalogue </h1>

The purpose of this project was to use different types of databases in a real software example that people may use everyday.
Therefore, I made a web-app similar to Amazon where you can: login and register, purchase products and leave comments below them, check what you have ordered and, among other things, use a search engine which shows suggestions of products while you are typing on it.

# Steps to use the application:
 
[<b>Download XAMPP</b>](https://www.apachefriends.org/es/download.html)

[<b>Download MongoDB Server</b>](https://www.mongodb.com/download-center/community)

> OPTIONAL

[<b> Download Robo 3T (MongoDB GUI)<b>](https://robomongo.org/download)
  
You have to make sure that both ports (in MongoDB and Robo 3T) are the 27017 one
  

[<b>Install the MongoDB driver for PHP</b>](https://pecl.php.net/package/mongodb/1.5.3/windows)

Your MongoDB version must match that of PHP. You should also pay attention to architecture and Thread Safe.
To that end, use the info.php file which I provided in this repository.
Then, copy the 'php_mongodb.dll' file and paste it into the path xampp/php/ext 
Now, edit 'php.ini', which is located in 'xampp/php', and add the next statement:
```
extension=php_mongodb.dll
```

<b>Execute mongod.exe</b>

<b>Now, execute mongo.exe. </b>
Here, execute the following commands:
```
use Product_Catalogue
```
This command will create our new database
```
db.createCollection("InfoProducto")
```
and this one will create the necessary collection for comments.

<b>Open the system console (CMD): </b>
Find the 'bin' folder in the MongoDB Server path and type the next command:
```
mongoimport -h localhost:27017 --db Product_Catalogue --collection InfoProducto --file C:\xampp\htdocs\Product_Catalogue\backend\MongoDB\MongoDB_database.json
```
> The xampp folder is supposed to be located at C:\

This command will import the necessary documents into our database.

<b>Open the XAMPP control panel and start Apache and MySQL</b>

<b>Import in phpMyAdmin the SQL files provided in this repository</b>

<b>Try my aplication typing in the browser the next URL</b>
```
localhost/Product_Catalogue/frontend/index.php
```
