## Launch environment

`docker-compose -f docker-compose_x86.yml up --build`

The environment is executed inside a WSL command window. 

Closing the window (or CTRL+C) where containers are executed shut down containers.

To access inside container, please be careful to have containers running.

## Access to containers

__Containers have to be running  for the following command to work.__

Following command needs to be entered in a different command window than the one where containers are running.

### Access website container

`docker exec -it www-mediatheque /bin/bash`

### Access documentation container

`docker exec -it doc-mediatheque /bin/bash`

### Access phpMyAdmin container

`docker exec -it pma-mediatheque /bin/bash`

### Access database container

`docker exec -it db-mediatheque /bin/bash`

### Quit a container

`exit`

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

### Make a migration (after entities modifications)

``php bin/console make:migration``

### Retrieve the last database migration

``php bin/console doctrine:migrations:latest``
> Sample response DoctrineMigrations\Version20220211020200

### Apply migration

``php bin/console doctrine:migrations:migrate``

### Perform a specific migration

``php bin/console doctrine:migrations:migrate DoctrineMigrations\Version20220211020200``

### View site routes

``php bin/console debug:router``

### Clear caches 

``php bin/console cache:clear``

### Install assets (images, css, javascript) in public folder

``php bin/console assets:install``

