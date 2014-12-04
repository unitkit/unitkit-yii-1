UNITKIT
========

UNITKIT is a CMS application.
Easy to configure and very fast.
You can mange user/groups/roles for each module, translations, languages, mail templates, pages, menu.
You can generate new module using the unitkit generator

Required Yii Framework 1.1.15

- Installing php lib :
	- mysql
	- apc or opcache with PHP 5.5
 	- memcached
 	- curl
 
- Installing "npm"

- Installing "Bower" in global mode :
	- npm install -g bower

- Create a database "unitkit" using file "unitkit/datas/db/db.sql"

- Installing backend :
	- Install website with console (install|install:components|clean:cache) :
	```bash
	$ unitkit/modules/backend/tools/console install
	```
	- Install dependencies :
	```bash
	$ cd public/backend
	$ bower install
	```
	- Create a new vhost pointing "public/backend" directory (default : backend.unitkit.local)
	- Generate a new application ID (should be unique) and update config file "unitkit/modules/backend/config/main.php" with new ID
	- Update config file "unitkit/modules/backend/config/main.php" in order to change database information

- Installing frontend :
	- Install website with console (install|install:components|clean:cache) :
	```bash
	$ unitkit/modules/frontend/tools/console install
	```
	- Install dependencies :
	```bash
	$ cd public/frontend
	$ bower install
	```
	- Create a new vhost pointing "public/frontend" directory (default : frontend.unitkit.local)
	- Generate a new application ID (should be unique) and update config file "unitkit/modules/frontend/config/main.php" with new ID
	- Update config file "unitkit/modules/frontend/config/main.php" in order to change database information

- Installing static :
    - Create a new vhost pointing "public/static" directory (default : static.unitkit.local)
    - Update backend config file "unitkit/modules/backend/config/main.php" in order to change url of static medias
    - Update frontend config file "unitkit/modules/frontend/config/main.php" in order to change url of static medias


UNITKIT SUR OVH MUTUALISE
=========================

- Installer UNITKIT selon la procédure précédente dans votre environnement de travail afin de récupérer les dépendances du module frontend et backend dans le répertoire public
- Installer la base de données sur phpmyadmin d'ovh
- Modifier les fichiers de configuration sur backend et frontend
- Copier les sources à la racine du ftp d'ovh
- Créer des sous domaines pour frontend (par exemple wwww), backend et static
- Modifier les urls de static dans le fichier de configuration
