# About project initialisation 

The Project has started following theses steps :

* 1 Run the docker-compose file to launch development Environment

    `docker-compose -f docker-compose_x86.yml up --build`

* 2 Go into the php server container and initiate a symfony project (folder has to be empty)

    `docker exec -it php-mediatheque /bin/bash`

    `rmdir site/public`

    `php ./composer.phar create-project symfony/skeleton site`

this as created an empty symfony site with a default Symfony page

* 3 Associate website and database by editing .env file and adding following : 

DATABASE_URL="mysql://root:mediathequeroot@db-mediatheque:3306/mediatheque?serverVersion=8.0"

then you can create an empty mediatheque schema with : 

``php bin/console doctrine:database:create``

* 4 Some symfony extension are required in order to properly use ORM, Templater, Maker, ...

to install a symfony module, first do inside php-mediatheque container by 

    `docker exec -it php-mediatheque /bin/bash`

    `cd site/`

Then install dependencies using executable composer.phar at the root of the container
    
`../composer.phar require symfony/twig-bundle`

`../composer.phar require symfony/orm-pack`

`../composer.phar require --dev symfony/maker-bundle`

`../composer.phar require form validator security-csrf`

`../composer.phar require --dev phpunit/phpunit`

* 5 Create entities following the datamodel (maker-bundle required)

`php bin/console make:entity TypeOeuvre`

`php bin/console make:entity TypeAuteur`

`php bin/console make:entity Lieu`

`php bin/console make:entity Serie`

`php bin/console make:entity Auteur`    !!! relation

`php bin/console make:entity Edition`

`php bin/console make:entity Oeuvre`    !!! relation

* 6 Now entities exists, ask doctrine to make a migration. 

This means that new tables have been added, MySQL has to make the database tables for thoses entities.

`php bin/console make:migration` 

Then apply migration

`php bin/console doctrine:migrations:migrate` 

check 
http://localhost:8812/

* 7 Now database and website are synchronised, create CRUD (form validator twig-bundle security-csrf required; phpUnit also if you want to generate automatically Unit tests)
 
`php bin/console make:crud TypeOeuvre`

`php bin/console make:crud TypeAuteur`

`php bin/console make:crud Lieu`

`php bin/console make:crud Serie`

`php bin/console make:crud Edition`

`php bin/console make:crud Auteur`

`php bin/console make:crud Oeuvre`

check 
localhost:8811/type/oeuvre/
localhost:8811/type/auteur/

* 8 Create Your first Controller AccueilController and its view index.html.twig to replace Synfony's default page

AccueilController.php:

```
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route(name: 'accueil', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Accueil/index.html.twig');
    }
}
```

index.html.twig :

```
{% extends 'base.html.twig' %}
{% block title %}Accueil Médiathèque{% endblock %}
{% block body %}<p>hello</p>{% endblock %}
```

check 
localhost:8811/

* 9 add a toString function for each entities to say which attribute(s) you want to display when entity is displayed.

* 10 modify base.html.twig to add a menu and bootstrap

* 10 Your turn...