# ProjetMediatheque
Computer engineering project for Master2 IIN at Université Jean Jaures. 
Support for the discovery of Docker, Symfony (Doctrine, Twig), Git. 

# Linux & Mac prerequisites
Docker and docker-compose installed.

# Windows prerequisites
Linux WSL2 and DockerDesktop installed.

# Usage

## WSL, Linux, MAC users
This tp is designed to run in WSL (or linux or mac).

## Windows users (cmd, powershell)
It can also be launched from a Windows command window (cmd) or a Powershell window.

Sometimes some files cannot be read ... replace the Unix linefeeds (LF) with Windows linefeeds (CRLF).
This can be done with notepad++ via Edit / Convert line breaks / Covert to Windows format (CR + LF), without forgetting to save the file.

This avoids, for instance; the error "=> ERROR [www 7/9] RUN php composer-setup.php" when launching containers.

Another well-known error is "Error: No such container: -it"

When pasting the command "docker exec -it php-mediatheque /bin/bash" (command 2. below),

Windows replaces the dash in the command (dash 6) with a long dash, which causes the error message

Solution: Type commands rather than copy and paste them.

# Clone the project

``git clone https://github.com/yaelchampclaux/ProjetMediatheque.git``

This creates a "ProjetMediatheque" folder.

# Launch the development environment 

``cd ProjetMediatheque``\
``docker-compose -f docker-compose_x86.yml up --build``

Be careful not to close the window in which the conatiners are running! 
Open another window to type the following commands

# Use the environment

1. Access the PHP container shell (in a command window other than the one in which the containers are launched)

``docker exec -it php-mediatheque /bin/bash``

2. Install symfony vendors

``cd site``\
``../composer.phar install``

This loads the dependencies described in our composer.json file. 
They are not in the git repository, as they can be generated with the previous command.

3. Create the database into db-mediatheque container by synchronizing (from /site in the php container) 

php bin/console doctrine:schema:update --force

This generates the database into MySQL from our code (the Entities in the /src folder of our site).

4. Add data to the media library (via PhpMyAdmin) 

Using your browser, go to phpMyAdmin http://localhost:8812/\
Then click on "mediatheque" database, then on "Import" then "Browse", then select the fill-mediatheque.sql file located in the /data folder of ProjetMediatheque.

5. Test

    - Mediatheque website : http://localhost:8811/

    - PhpMyAdmin http://localhost:8812/

    - Documentation http://localhost:8813/

# Other useful commands

## Docker 

Container management commands

### Command to access MySQL container shell

``docker exec -it db-mediatheque /bin/bash``

### To find out which processes are running and exited

``docker ps -a``

### To stop a running container (it shuts down cleanly)

``docker stop *container_id or container_name*``

### To stop a running container immediately

``docker kill *container_id or container_name*``

### To delete a stopped container

``docker rm *container_id or container_name*``

### Restart one or more containers

``docker restart *container_id1 container_id2 ... or container_name1 ...*``

### Usage stat

docker stat

## Symfony 

For the following commands, we'll assume you're in the /site folder of the php-mediatheque container. 

### List available Symfony console commands

``php bin/console list``

### Retrieve the last database migration

``php bin/console doctrine:migrations:latest``
> Sample response DoctrineMigrations\Version20220211020200

### Perform migration

``php bin/console doctrine:migrations:migrate``

### Perform a specific migration

``php bin/console doctrine:migrations:migrate DoctrineMigrations\Version20220211020200``

### View site routes

``php bin/console debug:router``

### Clear caches 

``php bin/console cache:clear``

### Install assets (images, css, javascript) in public folder

``php bin/console assets:install``


