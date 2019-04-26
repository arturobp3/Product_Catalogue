Instrucciones para instalar y probar la aplicación
--------------------------------------------------

1.- Descargar XAMPP
------------------
https://www.apachefriends.org/es/download.html


2.- Descargar MongoDB Server
----------------------------
https://www.mongodb.com/dr/fastdl.mongodb.org/win32/mongodb-win32-x86_64-2008plus-ssl-4.0.9.zip/download


3.- Descargar Robo 3T (Opcional)
--------------------------------
https://robomongo.org/download
Asegurarse de que ambos puertos (tanto el de MongoDB Server y Robo 3T) son el 27017


4.- Instalar driver MongoDB para PHP
------------------------------------
Para ello mirar la version de tu PHP, la arquitectura y el Thread Safe (utilizar el fichero info.php
incluido en el proyecto) y buscar cual se corresponde con el tuyo.
Descargar el driver del siguiente link:
https://pecl.php.net/package/mongodb/1.5.3/windows

Copiamos el archivo php_mongodb.dll y lo pegamos en la carpeta xampp/php/ext
En la carpeta xampp/php editamos el archivo php.ini y copiamos la siguiente sentencia:
    extension=php_mongodb.dll
Comprobamos en la pagina info.php que se ha instalado correctamente mongoDB



5.- Ejecutar mongod.exe. Se encuentra en la carpeta 'bin' de MongoDB Server
---------------------------------------------------------------------------

6.- Ejecutar mongo.exe (Cliente)
--------------------------------
Ejecutar en este los siguientes comandos:

    - use Product_Catalogue
    - db.createCollection("InfoProducto")


7.- Abrir la consola del sistema (CMD), navegar hasta la carpeta 'bin' de MongoDB Server y ejecutar
    el siguiente comando:
    ------------------------------------------------------------------------------------------------ 
	mongoimport -h localhost:27017 --db Product_Catalogue --collection InfoProducto --file C:\xampp\htdocs\
	Product_Catalogue\backend\MongoDB\MongoDB_database.json

    (Suponiendo que la carpeta de instalacion de xampp se encuentre en C:\)

    (
        Si se necesita exportar la base de datos por algún motivo el comando es el siguiente:
        mongoexport --db Product_Catalogue --collection InfoProducts --out C:\rutaquequieras
    )


    Con esto habremos importado los documentos necesarios para guardar los comentarios de todos los productos


8.- Abrir el panel de control de XAMPP e inicializar Apache y MySQL
-------------------------------------------------------------------

9.- Crear una carpeta llamada 'Product_Catalogue' y meter en ella tanto la carpeta 'backend' como 'frontend'
------------------------------------------------------------------------------------------------------------

10.- Meter la carpeta 'Product_Catalogue' en la ruta /xampp/htdocs
------------------------------------------------------------------


11.- Entrar en el navegador e introducir la siguiente direccion: localhost/phpmyadmin
-------------------------------------------------------------------------------------

12.- Importar los ficheros .sql incluidos en /backend/mysql para importar la base de datos que necesita la aplicacion
---------------------------------------------------------------------------------------------------------------------

13.- Entrar en la siguiente URL: localhost/Product_Catalogue/frontend/index.php
-------------------------------------------------------------------------------


Si todo ha ido correctamente la aplicación funcionará.



