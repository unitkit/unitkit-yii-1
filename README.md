UNITKIT
========

Required Yii Framework 1.1.15

- Installing php lib :
	- mysql
	- apc or opcache with PHP 5.5
 	- memcached
 	- curl
 
- Installing "npm"

- Installing "Bower" in global mode :
	- npm install -g bower
 
- Installing backend :
	- Create a database "unitkit" using file "unitkit/datas/db/db.sql"
	- Install website with console (install|install:components|clean:cache) :
	```bash
	$ unitkit/modules/backend/tools/console install
	```
	- Install dependencies :
	```bash
	$ cd public/backend
	$ bower install
	```
	- Create a new vhost from public/backend
	- Generate a new application ID and update config file "unitkit/modules/backend/config/main.php" with new ID
