##Guia para correr el proyecto en entorno Windows  

##Requisitos:  
Tener instalado PHP (version 8.1 o mayor) y MySql (preferentemente version 8.0 o mayor).  

##Pasos a seguir:  
0- Iniciar MySQL  
- Si es la primera vez que ejecutás MySQL, hay que inicializar la base de datos abriendo una consola en modo administrador, navegar a la carpeta bin dentro del directorio de instalación de MySQL Server y ejecutar: .\mysqld.exe --initialize --console  
- El anterior comando crea la carpeta data y genera los archivos internos necesarios. También mostrará una clave temporal para el usuario root, la cual sera necesaria en el primer inicio de sesión donde te pediran crear la contraseña definitiva.  
- Luego, para iniciar el servidor MySQL, ejecutar en una consola en modo administrador, tambien dentro de la carpeta bin: .\mysqld.exe

1- Descargar este repositorio y dirigirse por consola a la raiz del proyecto para crear la base de datos y migrar las tablas con el comando: php artisan migrate --seed  
2- Nuevamente en la raíz del proyecto, para iniciar el servidor, utilizar el comando por consola: php artisan serve  
3- Abrir el navegador y dirigirse a la url http://127.0.0.1:8000/api/documentation para interactuar con swagger. Si desea acceder a los endpoints de forma manual, los siguientes se encuentran habilitados:  

##Endpoints  
GET http://127.0.0.1:8000/api/test  
POST http://127.0.0.1:8000/api/register  
POST http://127.0.0.1:8000/api/login  
POST http://127.0.0.1:8000/api/logout (solo accesible por usuarios autenticados)  
GET http://127.0.0.1:8000/api/users (solo accesible por usuarios autenticados)  
GET http://127.0.0.1:8000/api/users/{id} (solo accesible por usuarios autenticados)  
UPDATE http://127.0.0.1:8000/api/users/{id} (solo accesible por usuarios autenticados)  
DELETE http://127.0.0.1:8000/api/users/{id} (solo accesible por usuarios autenticados)  
POST http://127.0.0.1:8000/api/posts (solo accesible por usuarios autenticados)  
GET http://127.0.0.1:8000/api/posts (solo accesible por usuarios autenticados)  
GET http://127.0.0.1:8000/api/posts/{id} (solo accesible por usuarios autenticados)  
UPDATE http://127.0.0.1:8000/api/posts/{id} (solo accesible por usuarios autenticados)  
DELETE http://127.0.0.1:8000/api/posts/{id} (solo accesible por usuarios autenticados)  

##IMPORTANTE  
_ Tener en cuenta que la ejecución de MySQL puede ser bloqueada por los antivirus, el firewall de Windows o por aplicaciones que estén utilizando el puerto 3306. Tomar las precauciones correspondientes.  
_ Este proyecto incluye las dependencias necesarias para que solo sea necesario clonarlo y ejecutar los pasos mencionados anteriormente. Sin embargo, está configurado para conectar a la base de datos con el usuario root y la contraseña pass. En caso de que estos datos no coincidan con los de tu instalación de MySQL, se pueden modificar desde el archivo .env  
